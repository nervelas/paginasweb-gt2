<?php
namespace App\Core;

/**
 * Construcción de metadatos y JSON-LD.
 * Regla del proyecto: solo se marcan datos reales y verificables.
 */
class Seo
{
    public static array $meta = [];

    public static function set(array $meta): void
    {
        self::$meta = array_merge(self::$meta, $meta);
    }

    public static function title(): string
    {
        return self::$meta['title'] ?? Settings::get('site_name', 'paginasweb.gt');
    }

    public static function organization(): array
    {
        $sameAs = array_values(array_filter([
            Settings::get('social_facebook'),
            Settings::get('social_instagram'),
            Settings::get('social_linkedin'),
            Settings::get('social_youtube'),
            Settings::get('parent_site_url'),
        ]));

        $org = [
            '@type'       => 'Organization',
            '@id'         => \base_url() . '#organization',
            'name'        => Settings::get('site_name', 'paginasweb.gt'),
            'legalName'   => Settings::get('legal_name', 'Servicom'),
            'url'         => \base_url(),
            'logo'        => [
                '@type'  => 'ImageObject',
                'url'    => \base_url('assets/img/logo-paginasweb-gt.svg'),
                'width'  => 320,
                'height' => 64,
            ],
            'email'       => Settings::get('email'),
            'telephone'   => Settings::get('phone_e164'),
            'foundingDate' => Settings::get('founding_year', '2007'),
            'address'     => [
                '@type'           => 'PostalAddress',
                'addressLocality' => Settings::get('city', 'Ciudad de Guatemala'),
                'addressRegion'   => Settings::get('region', 'Guatemala'),
                'addressCountry'  => 'GT',
            ],
            'areaServed'  => [
                ['@type' => 'Country', 'name' => 'Guatemala'],
            ],
        ];
        if ($sameAs) {
            $org['sameAs'] = $sameAs;
        }
        $parent = Settings::get('parent_site_url');
        if ($parent) {
            $org['parentOrganization'] = [
                '@type' => 'Organization',
                'name'  => Settings::get('legal_name', 'Servicom'),
                'url'   => $parent,
            ];
        }
        return $org;
    }

    public static function localBusiness(): array
    {
        $lb = [
            '@type'       => 'ProfessionalService',
            '@id'         => \base_url() . '#localbusiness',
            'name'        => Settings::get('site_name', 'paginasweb.gt'),
            'url'         => \base_url(),
            'image'       => \base_url('assets/img/og/og-home.webp'),
            'email'       => Settings::get('email'),
            'telephone'   => Settings::get('phone_e164'),
            'priceRange'  => Settings::get('price_range', 'Q1,250 - Q3,600'),
            'currenciesAccepted' => 'GTQ',
            'address'     => [
                '@type'           => 'PostalAddress',
                'addressLocality' => Settings::get('city', 'Ciudad de Guatemala'),
                'addressRegion'   => Settings::get('region', 'Guatemala'),
                'addressCountry'  => 'GT',
            ],
            'areaServed'  => ['@type' => 'Country', 'name' => 'Guatemala'],
            'parentOrganization' => ['@id' => \base_url() . '#organization'],
        ];
        $hours = Settings::get('opening_hours_spec');
        if ($hours) {
            $decoded = json_decode($hours, true);
            if (is_array($decoded)) {
                $lb['openingHoursSpecification'] = $decoded;
            }
        }
        return $lb;
    }

    public static function website(): array
    {
        return [
            '@type'    => 'WebSite',
            '@id'      => \base_url() . '#website',
            'url'      => \base_url(),
            'name'     => Settings::get('site_name', 'paginasweb.gt'),
            'inLanguage' => 'es-GT',
            'publisher'  => ['@id' => \base_url() . '#organization'],
        ];
    }

    public static function breadcrumbs(array $items): array
    {
        $list = [];
        $pos  = 1;
        foreach ($items as $item) {
            $list[] = [
                '@type'    => 'ListItem',
                'position' => $pos++,
                'name'     => $item['name'],
                'item'     => $item['url'],
            ];
        }
        return ['@type' => 'BreadcrumbList', 'itemListElement' => $list];
    }

    public static function faqPage(array $faqs): ?array
    {
        if (!$faqs) {
            return null;
        }
        $items = [];
        foreach ($faqs as $faq) {
            $items[] = [
                '@type'          => 'Question',
                'name'           => $faq['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text'  => trim(strip_tags($faq['answer'], '<p><br><ul><li><strong><a>')),
                ],
            ];
        }
        return ['@type' => 'FAQPage', 'mainEntity' => $items];
    }

    public static function service(array $service, array $plans = []): array
    {
        $node = [
            '@type'       => 'Service',
            'name'        => $service['name'],
            'description' => $service['description'],
            'serviceType' => $service['service_type'] ?? $service['name'],
            'provider'    => ['@id' => \base_url() . '#organization'],
            'areaServed'  => ['@type' => 'Country', 'name' => 'Guatemala'],
            'url'         => $service['url'],
        ];
        $offers = [];
        foreach ($plans as $plan) {
            if (!is_numeric($plan['price'])) {
                continue;
            }
            $offers[] = array_filter([
                '@type'         => 'Offer',
                'name'          => $plan['name'],
                'price'         => (string) (float) $plan['price'],
                'priceCurrency' => 'GTQ',
                'url'           => $plan['url'] ?? $service['url'],
                'availability'  => 'https://schema.org/InStock',
                'priceValidUntil' => $plan['price_valid_until'] ?? null,
            ]);
        }
        if (count($offers) === 1) {
            $node['offers'] = $offers[0];
        } elseif (count($offers) > 1) {
            $prices = array_map(fn($o) => (float) $o['price'], $offers);
            $node['offers'] = [
                '@type'         => 'AggregateOffer',
                'priceCurrency' => 'GTQ',
                'lowPrice'      => (string) min($prices),
                'highPrice'     => (string) max($prices),
                'offerCount'    => (string) count($offers),
                'offers'        => $offers,
            ];
        }
        return $node;
    }

    public static function article(array $post): array
    {
        return array_filter([
            '@type'            => 'Article',
            'headline'         => mb_substr($post['title'], 0, 110),
            'description'      => $post['meta_description'] ?? $post['excerpt'],
            'image'            => $post['image_url'] ?? null,
            'datePublished'    => date('c', strtotime($post['published_at'])),
            'dateModified'     => date('c', strtotime($post['updated_at'] ?: $post['published_at'])),
            'inLanguage'       => 'es-GT',
            'author'           => [
                '@type' => 'Organization',
                'name'  => Settings::get('site_name', 'paginasweb.gt'),
                'url'   => \base_url(),
            ],
            'publisher'        => ['@id' => \base_url() . '#organization'],
            'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => $post['url']],
        ]);
    }

    /** Empaqueta los nodos en un solo bloque @graph. */
    public static function graph(array $nodes): string
    {
        $graph = array_values(array_filter($nodes));
        $json  = [
            '@context' => 'https://schema.org',
            '@graph'   => $graph,
        ];
        return json_encode($json, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
