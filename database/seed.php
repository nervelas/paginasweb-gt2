<?php
/**
 * Carga el contenido inicial en la base de datos usando sentencias preparadas.
 * Se ejecuta desde el instalador o con:  php tools/seed.php
 */

use App\Core\Database;

class Seeder
{
    /** @var string */
    private $dir;
    /** @var array */
    public $log = [];

    public function __construct($contentDir)
    {
        $this->dir = rtrim($contentDir, '/');
    }

    public function run()
    {
        $this->seedSettings();
        $this->seedMenus();
        $this->seedServices();
        $this->seedPortfolio();
        $this->seedCategories();
        $this->seedPages();
        $this->seedFaqs();
        $this->seedPosts();
        return $this->log;
    }

    private function note($text)
    {
        $this->log[] = $text;
    }

    private function load($file)
    {
        $path = $this->dir . '/' . $file;
        if (!is_file($path)) {
            return [];
        }
        return require $path;
    }

    // ------------------------------------------------------------- settings
    private function seedSettings()
    {
        $settings = $this->load('settings.php');
        $count = 0;
        foreach ($settings as $key => $value) {
            $exists = Database::value('SELECT COUNT(*) FROM settings WHERE setting_key = ?', [$key]);
            if ($exists) {
                continue;
            }
            Database::insert('settings', ['setting_key' => $key, 'setting_value' => (string) $value]);
            $count++;
        }
        $this->note($count . ' opciones de configuración');
    }

    // ---------------------------------------------------------------- menús
    private function seedMenus()
    {
        if (Database::value('SELECT COUNT(*) FROM menu_items')) {
            $this->note('Menús: ya existían, no se tocaron');
            return;
        }
        $menus = $this->load('menus.php');
        $count = 0;
        foreach ($menus as $location => $items) {
            $order = 1;
            foreach ($items as $item) {
                Database::insert('menu_items', [
                    'location'   => $location,
                    'label'      => $item['label'],
                    'url'        => $item['url'],
                    'parent_id'  => null,
                    'rel'        => isset($item['rel']) ? $item['rel'] : null,
                    'sort_order' => $order++,
                    'visible'    => 1,
                ]);
                $count++;
            }
        }
        $this->note($count . ' enlaces de menú');
    }

    // ----------------------------------------------------- servicios y planes
    private function seedServices()
    {
        if (Database::value('SELECT COUNT(*) FROM services')) {
            $this->note('Servicios: ya existían, no se tocaron');
            return;
        }
        $services = $this->load('services.php');
        $plans = 0;
        foreach ($services as $service) {
            $serviceId = Database::insert('services', [
                'slug'       => $service['slug'],
                'name'       => $service['name'],
                'short_name' => $service['short_name'],
                'tagline'    => $service['tagline'],
                'summary'    => $service['summary'],
                'icon'       => $service['icon'],
                'page_slug'  => $service['page_slug'],
                'sort_order' => $service['sort_order'],
                'visible'    => 1,
            ]);
            foreach ($service['plans'] as $plan) {
                Database::insert('plans', [
                    'service_id'      => $serviceId,
                    'name'            => $plan['name'],
                    'badge'           => isset($plan['badge']) ? $plan['badge'] : null,
                    'price'           => isset($plan['price']) ? $plan['price'] : null,
                    'price_text'      => isset($plan['price_text']) ? $plan['price_text'] : null,
                    'price_strike'    => isset($plan['price_strike']) ? $plan['price_strike'] : null,
                    'period'          => $plan['period'],
                    'price_note'      => isset($plan['price_note']) ? $plan['price_note'] : null,
                    'initial_payment' => isset($plan['initial_payment']) ? $plan['initial_payment'] : null,
                    'balance_payment' => isset($plan['balance_payment']) ? $plan['balance_payment'] : null,
                    'features'        => implode("\n", $plan['features']),
                    'cta_text'        => $plan['cta_text'],
                    'cta_url'         => $plan['cta_url'],
                    'featured'        => $plan['featured'],
                    'sort_order'      => $plan['sort_order'],
                    'visible'         => 1,
                ]);
                $plans++;
            }
        }
        $this->note(count($services) . ' servicios y ' . $plans . ' planes');
    }

    // ----------------------------------------------------------- portafolio
    private function seedPortfolio()
    {
        if (Database::value('SELECT COUNT(*) FROM portfolio')) {
            $this->note('Portafolio: ya existía, no se tocó');
            return;
        }
        $items = $this->load('portfolio.php');
        $order = 1;
        foreach ($items as $item) {
            $slug = str_replace('.', '-', $item['domain']);
            Database::insert('portfolio', [
                'name'        => $item['name'],
                'domain'      => $item['domain'],
                'url'         => 'https://' . $item['domain'],
                'sector'      => $item['sector'],
                'description' => $item['description'],
                'image'       => '/assets/img/portafolio/' . $slug . '.webp',
                'image_alt'   => 'Presentación del proyecto web de ' . $item['name'] . ' (' . $item['domain'] . ')',
                'sort_order'  => $order++,
                'visible'     => 1,
            ]);
        }
        $this->note(count($items) . ' proyectos del portafolio');
    }

    // ----------------------------------------------------------- categorías
    private function seedCategories()
    {
        if (Database::value('SELECT COUNT(*) FROM categories')) {
            return;
        }
        $cats = $this->load('categories.php');
        $order = 1;
        foreach ($cats as $cat) {
            Database::insert('categories', [
                'slug'        => $cat['slug'],
                'name'        => $cat['name'],
                'description' => $cat['description'],
                'sort_order'  => $order++,
            ]);
        }
        $this->note(count($cats) . ' categorías del blog');
    }

    // --------------------------------------------------------------- páginas
    private function seedPages()
    {
        if (Database::value('SELECT COUNT(*) FROM pages')) {
            $this->note('Páginas: ya existían, no se tocaron');
            return;
        }
        $files = glob($this->dir . '/pages/*.php');
        sort($files);
        $now = date('Y-m-d H:i:s');
        $sections = 0;

        foreach ($files as $file) {
            $page = require $file;
            $pageId = Database::insert('pages', [
                'slug'             => $page['slug'],
                'name'             => $page['name'],
                'h1'               => $page['h1'],
                'intro'            => isset($page['intro']) ? $page['intro'] : null,
                'meta_title'       => $page['meta_title'],
                'meta_description' => $page['meta_description'],
                'canonical'        => null,
                'robots_index'     => isset($page['robots_index']) ? $page['robots_index'] : 1,
                'og_image'         => isset($page['og_image']) ? $page['og_image'] : null,
                'template'         => $page['template'],
                'sort_order'       => $page['sort_order'],
                'visible'          => 1,
                'updated_at'       => $now,
            ]);

            $order = 1;
            foreach ($page['sections'] as $section) {
                Database::insert('page_sections', [
                    'page_id'    => $pageId,
                    'block_type' => $section['block_type'],
                    'eyebrow'    => isset($section['eyebrow']) ? $section['eyebrow'] : null,
                    'heading'    => isset($section['heading']) ? $section['heading'] : null,
                    'subheading' => isset($section['subheading']) ? $section['subheading'] : null,
                    'body'       => isset($section['body']) ? $section['body'] : null,
                    'image'      => isset($section['image']) ? $section['image'] : null,
                    'image_alt'  => isset($section['image_alt']) ? $section['image_alt'] : null,
                    'cta_text'   => isset($section['cta_text']) ? $section['cta_text'] : null,
                    'cta_url'    => isset($section['cta_url']) ? $section['cta_url'] : null,
                    'extra'      => isset($section['extra']) ? json_encode($section['extra'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : null,
                    'sort_order' => $order++,
                    'visible'    => 1,
                ]);
                $sections++;
            }
        }
        $this->note(count($files) . ' páginas con ' . $sections . ' secciones');
    }

    // ------------------------------------------------------------------ FAQ
    private function seedFaqs()
    {
        if (Database::value('SELECT COUNT(*) FROM faqs')) {
            return;
        }
        $faqs = $this->load('faqs.php');
        $orders = [];
        foreach ($faqs as $faq) {
            $slug = $faq['page_slug'];
            $orders[$slug] = isset($orders[$slug]) ? $orders[$slug] + 1 : 1;
            Database::insert('faqs', [
                'page_slug'  => $slug,
                'question'   => $faq['question'],
                'answer'     => $faq['answer'],
                'sort_order' => $orders[$slug],
                'visible'    => 1,
            ]);
        }
        $this->note(count($faqs) . ' preguntas frecuentes');
    }

    // -------------------------------------------------------------- entradas
    private function seedPosts()
    {
        if (Database::value('SELECT COUNT(*) FROM posts')) {
            $this->note('Blog: ya existía, no se tocó');
            return;
        }
        $files = glob($this->dir . '/posts/*.php');
        sort($files);
        foreach ($files as $file) {
            $post = require $file;
            $categoryId = Database::value('SELECT id FROM categories WHERE slug = ?', [$post['category']]);
            Database::insert('posts', [
                'slug'             => $post['slug'],
                'title'            => $post['title'],
                'excerpt'          => $post['excerpt'],
                'body'             => $post['body'],
                'image'            => $post['image'],
                'image_alt'        => $post['image_alt'],
                'category_id'      => $categoryId ? $categoryId : null,
                'author'           => 'Equipo de paginasweb.gt',
                'published_at'     => $post['published_at'],
                'updated_at'       => $post['published_at'],
                'meta_title'       => $post['meta_title'],
                'meta_description' => $post['meta_description'],
                'robots_index'     => 1,
                'visible'          => 1,
            ]);
        }
        $this->note(count($files) . ' artículos del blog');
    }
}
