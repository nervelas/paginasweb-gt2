<?php
namespace App\Controllers;

use App\Core\Csrf;
use App\Core\Security;
use App\Core\Database;
use App\Core\Mailer;
use App\Core\Seo;
use App\Core\Settings;
use App\Models\Content;

class SiteController
{
    /** Página de contenido (incluye el inicio con slug vacío). */
    public function page($slug)
    {
        $page = Content::page($slug);
        if (!$page) {
            return $this->notFound();
        }

        $sections = Content::sections($page['id']);
        $faqs     = Content::faqs($slug);
        $url      = \url($slug === '' ? '/' : '/' . $slug . '/');

        $crumbs = [['name' => 'Inicio', 'url' => \url('/')]];
        if ($slug !== '') {
            $crumbs[] = ['name' => $page['name'], 'url' => $url];
        }

        $graph = [Seo::organization(), Seo::localBusiness(), Seo::website()];
        if (count($crumbs) > 1) {
            $graph[] = Seo::breadcrumbs($crumbs);
        }
        if ($faqs) {
            $graph[] = Seo::faqPage($faqs);
        }

        // Schema de servicio en las páginas de servicio
        $serviceSlug = $this->serviceSlugForPage($slug);
        if ($serviceSlug) {
            $service = Content::service($serviceSlug);
            if ($service) {
                $plans = array_map(function ($p) use ($url) {
                    return ['name' => $p['name'], 'price' => $p['price'], 'url' => $url];
                }, Content::plans($service['id']));
                $graph[] = Seo::service([
                    'name'        => $service['name'],
                    'description' => $service['summary'],
                    'url'         => $url,
                ], $plans);
            }
        }
        if ($slug === 'precios') {
            foreach (Content::plansByService() as $group) {
                $plans = array_map(function ($p) use ($url) {
                    return ['name' => $p['name'], 'price' => $p['price'], 'url' => $url];
                }, $group['plans']);
                $graph[] = Seo::service([
                    'name'        => $group['service']['name'],
                    'description' => $group['service']['summary'],
                    'url'         => \url('/' . $group['service']['page_slug'] . '/'),
                ], $plans);
            }
        }

        return \view('pages/render', [
            'page'      => $page,
            'sections'  => $sections,
            'faqs'      => $faqs,
            'crumbs'    => $crumbs,
            'seo'       => $this->seoFor($page, $url),
            'jsonld'    => Seo::graph($graph),
            'bodyClass' => 'tpl-' . $page['template'],
        ]);
    }

    private function serviceSlugForPage($slug)
    {
        $service = Database::first('SELECT slug FROM services WHERE page_slug = ? AND visible = 1', [$slug]);
        return $service ? $service['slug'] : null;
    }

    private function seoFor($page, $url)
    {
        return [
            'title'       => $page['meta_title'],
            'description' => $page['meta_description'],
            'canonical'   => $page['canonical'] ? $page['canonical'] : $url,
            'robots'      => $page['robots_index'] ? 'index, follow, max-image-preview:large' : 'noindex, follow',
            'og_image'    => $page['og_image'] ? \url($page['og_image']) : \url('/assets/img/og/og-inicio.webp'),
            'og_type'     => 'website',
        ];
    }

    /** Listado del blog. */
    public function blogIndex()
    {
        $page = Content::page('blog');
        if (!$page) {
            return $this->notFound();
        }
        $posts  = Content::posts();
        $url    = \url('/blog/');
        $crumbs = [
            ['name' => 'Inicio', 'url' => \url('/')],
            ['name' => 'Blog',   'url' => $url],
        ];

        return \view('blog/index', [
            'page'       => $page,
            'sections'   => Content::sections($page['id']),
            'posts'      => $posts,
            'categories' => Content::categories(),
            'crumbs'     => $crumbs,
            'seo'        => $this->seoFor($page, $url),
            'jsonld'     => Seo::graph([
                Seo::organization(),
                Seo::website(),
                Seo::breadcrumbs($crumbs),
            ]),
            'bodyClass'  => 'tpl-blog',
        ]);
    }

    /** Entrada del blog. */
    public function post($slug)
    {
        $post = Content::post($slug);
        if (!$post) {
            return $this->notFound();
        }
        $url = \url('/blog/' . $post['slug'] . '/');
        $crumbs = [
            ['name' => 'Inicio', 'url' => \url('/')],
            ['name' => 'Blog',   'url' => \url('/blog/')],
            ['name' => $post['title'], 'url' => $url],
        ];

        $article = Seo::article([
            'title'            => $post['title'],
            'meta_description' => $post['meta_description'],
            'excerpt'          => $post['excerpt'],
            'image_url'        => $post['image'] ? \url($post['image']) : null,
            'published_at'     => $post['published_at'],
            'updated_at'       => $post['updated_at'],
            'url'              => $url,
        ]);

        return \view('blog/single', [
            'post'     => $post,
            'related'  => Content::relatedPosts($post, 3),
            'crumbs'   => $crumbs,
            'seo'      => [
                'title'       => $post['meta_title'] ? $post['meta_title'] : $post['title'],
                'description' => $post['meta_description'] ? $post['meta_description'] : $post['excerpt'],
                'canonical'   => $url,
                'robots'      => $post['robots_index'] ? 'index, follow, max-image-preview:large' : 'noindex, follow',
                'og_image'    => $post['image'] ? \url($post['image']) : \url('/assets/img/og/og-blog.webp'),
                'og_type'     => 'article',
            ],
            'jsonld'   => Seo::graph([
                Seo::organization(),
                Seo::website(),
                Seo::breadcrumbs($crumbs),
                $article,
            ]),
            'bodyClass' => 'tpl-post',
        ]);
    }

    /**
     * Categoría del blog. Se marca noindex a propósito: con pocos artículos
     * por categoría, indexar estos listados generaría páginas de poco valor.
     */
    public function category($slug)
    {
        $category = Content::category($slug);
        if (!$category) {
            return $this->notFound();
        }
        $url = \url('/blog/categoria/' . $category['slug'] . '/');
        $crumbs = [
            ['name' => 'Inicio', 'url' => \url('/')],
            ['name' => 'Blog',   'url' => \url('/blog/')],
            ['name' => $category['name'], 'url' => $url],
        ];

        return \view('blog/category', [
            'category'   => $category,
            'posts'      => Content::posts(0, $category['id']),
            'categories' => Content::categories(),
            'crumbs'     => $crumbs,
            'seo'        => [
                'title'       => $category['name'] . ' | Blog de paginasweb.gt',
                'description' => $category['description'],
                'canonical'   => $url,
                'robots'      => 'noindex, follow',
                'og_image'    => \url('/assets/img/og/og-blog.webp'),
                'og_type'     => 'website',
            ],
            'jsonld'    => Seo::graph([Seo::organization(), Seo::website(), Seo::breadcrumbs($crumbs)]),
            'bodyClass' => 'tpl-blog',
        ]);
    }

    /** Recepción del formulario de cotización. */
    public function contactSubmit()
    {
        Csrf::verifyOrFail();

        $data = [
            'name'    => trim(isset($_POST['name']) ? $_POST['name'] : ''),
            'email'   => trim(isset($_POST['email']) ? $_POST['email'] : ''),
            'phone'   => trim(isset($_POST['phone']) ? $_POST['phone'] : ''),
            'service' => trim(isset($_POST['service']) ? $_POST['service'] : ''),
            'message' => trim(isset($_POST['message']) ? $_POST['message'] : ''),
        ];
        $honeypot = trim(isset($_POST['website']) ? $_POST['website'] : '');

        // Límite de envíos por IP: frena el correo masivo automatizado sin
        // estorbarle a nadie que escriba de verdad.
        if (Security::excedeEnvios(Security::ip())) {
            $_SESSION['_flash'] = [
                'message' => 'Ya recibimos varios mensajes desde esta conexión. Escribinos por WhatsApp o volvé a intentar en una hora.',
                'type'    => 'error',
            ];
            \redirect('/contacto/#formulario');
        }

        $errors = [];
        if ($data['name'] === '' || mb_strlen($data['name']) < 2) {
            $errors['name'] = 'Escribí tu nombre.';
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Revisá tu correo electrónico.';
        }
        if ($data['phone'] !== '' && !preg_match('/^[\d\s\+\-\(\)]{7,20}$/', $data['phone'])) {
            $errors['phone'] = 'Revisá el número de teléfono.';
        }
        if (mb_strlen($data['message']) < 10) {
            $errors['message'] = 'Contanos un poco más (al menos 10 caracteres).';
        }
        if (mb_strlen($data['message']) > 4000) {
            $errors['message'] = 'El mensaje es demasiado largo.';
        }

        // Trampa para robots: si viene lleno, se descarta en silencio.
        if ($honeypot !== '') {
            $_SESSION['_flash'] = ['message' => Settings::get('form_thanks'), 'type' => 'ok'];
            \redirect('/contacto/?enviado=1');
        }

        if ($errors) {
            $_SESSION['_old']         = $data;
            $_SESSION['_form_errors'] = $errors;
            $_SESSION['_flash']       = ['message' => 'Revisá los datos marcados y volvé a enviar.', 'type' => 'error'];
            \redirect('/contacto/#formulario');
        }

        Database::insert('messages', [
            'name'       => mb_substr($data['name'], 0, 160),
            'email'      => mb_substr($data['email'], 0, 190),
            'phone'      => mb_substr($data['phone'], 0, 60),
            'service'    => mb_substr($data['service'], 0, 120),
            'message'    => $data['message'],
            'page'       => mb_substr(isset($_POST['page']) ? $_POST['page'] : '/contacto/', 0, 255),
            'ip'         => mb_substr(isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '', 0, 45),
            'user_agent' => mb_substr(isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '', 0, 255),
            'status'     => 'nuevo',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        Mailer::notifyNewMessage($data);

        unset($_SESSION['_old'], $_SESSION['_form_errors']);
        $_SESSION['_flash'] = ['message' => Settings::get('form_thanks'), 'type' => 'ok'];
        \redirect('/contacto/?enviado=1#formulario');
    }

    /** robots.txt dinámico. */
    public function robots()
    {
        header('Content-Type: text/plain; charset=UTF-8');
        $lines = ['User-agent: *'];
        if (Settings::get('site_noindex', '0') === '1') {
            $lines[] = 'Disallow: /';
        } else {
            $lines[] = 'Disallow: /admin/';
            $lines[] = 'Disallow: /install.php';
            $lines[] = 'Disallow: /blog/categoria/';
            $lines[] = 'Allow: /';
        }
        $lines[] = '';
        $lines[] = 'Sitemap: ' . \url('/sitemap.xml');
        echo implode("\n", $lines) . "\n";
        return null;
    }

    /** sitemap.xml dinámico. */
    public function sitemap()
    {
        header('Content-Type: application/xml; charset=UTF-8');
        $urls = [];

        foreach (Content::pages() as $page) {
            if (!$page['robots_index']) {
                continue;
            }
            $loc = $page['slug'] === '' ? \url('/') : \url('/' . $page['slug'] . '/');
            $urls[] = [
                'loc'      => $loc,
                'lastmod'  => date('Y-m-d', strtotime($page['updated_at'])),
                'priority' => $page['slug'] === '' ? '1.0' : '0.8',
            ];
        }
        foreach (Content::posts() as $post) {
            if (!$post['robots_index']) {
                continue;
            }
            $urls[] = [
                'loc'      => \url('/blog/' . $post['slug'] . '/'),
                'lastmod'  => date('Y-m-d', strtotime($post['updated_at'] ? $post['updated_at'] : $post['published_at'])),
                'priority' => '0.6',
            ];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($urls as $u) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>' . htmlspecialchars($u['loc'], ENT_XML1) . "</loc>\n";
            $xml .= '    <lastmod>' . $u['lastmod'] . "</lastmod>\n";
            $xml .= '    <priority>' . $u['priority'] . "</priority>\n";
            $xml .= "  </url>\n";
        }
        $xml .= '</urlset>';
        echo $xml;
        return null;
    }

    public function notFound()
    {
        http_response_code(404);
        return \view('errors/404', [
            'seo' => [
                'title'       => 'Página no encontrada | paginasweb.gt',
                'description' => 'La dirección que buscás no existe o cambió de lugar.',
                'canonical'   => null,
                'robots'      => 'noindex, follow',
                'og_image'    => \url('/assets/img/og/og-inicio.webp'),
                'og_type'     => 'website',
            ],
            'crumbs'    => [],
            'jsonld'    => null,
            'bodyClass' => 'tpl-404',
        ]);
    }
}
