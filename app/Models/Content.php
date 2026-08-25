<?php
namespace App\Models;

use App\Core\Database;

/** Consultas de contenido del sitio público. */
class Content
{
    public static function page($slug)
    {
        return Database::first('SELECT * FROM pages WHERE slug = ? AND visible = 1', [$slug]);
    }

    public static function pages()
    {
        return Database::all('SELECT * FROM pages WHERE visible = 1 ORDER BY sort_order, id');
    }

    public static function sections($pageId)
    {
        $rows = Database::all(
            'SELECT * FROM page_sections WHERE page_id = ? AND visible = 1 ORDER BY sort_order, id',
            [$pageId]
        );
        foreach ($rows as $i => $row) {
            $rows[$i]['extra'] = $row['extra'] ? json_decode($row['extra'], true) : [];
        }
        return $rows;
    }

    public static function services()
    {
        return Database::all('SELECT * FROM services WHERE visible = 1 ORDER BY sort_order, id');
    }

    public static function service($slug)
    {
        return Database::first('SELECT * FROM services WHERE slug = ? AND visible = 1', [$slug]);
    }

    public static function plans($serviceId = null)
    {
        if ($serviceId === null) {
            return Database::all('SELECT * FROM plans WHERE visible = 1 ORDER BY sort_order, id');
        }
        return Database::all(
            'SELECT * FROM plans WHERE service_id = ? AND visible = 1 ORDER BY sort_order, id',
            [$serviceId]
        );
    }

    /** Planes agrupados por servicio, en el orden de los servicios. */
    public static function plansByService()
    {
        $out = [];
        foreach (self::services() as $service) {
            $out[] = ['service' => $service, 'plans' => self::plans($service['id'])];
        }
        return $out;
    }

    public static function portfolio($limit = 0)
    {
        $sql = 'SELECT * FROM portfolio WHERE visible = 1 ORDER BY sort_order, id';
        if ($limit > 0) {
            $sql .= ' LIMIT ' . (int) $limit;
        }
        return Database::all($sql);
    }

    public static function faqs($pageSlug)
    {
        return Database::all(
            'SELECT * FROM faqs WHERE page_slug = ? AND visible = 1 ORDER BY sort_order, id',
            [$pageSlug]
        );
    }

    public static function testimonials()
    {
        return Database::all('SELECT * FROM testimonials WHERE visible = 1 ORDER BY sort_order, id');
    }

    public static function posts($limit = 0, $categoryId = null)
    {
        $params = [];
        $sql = 'SELECT p.*, c.name AS category_name, c.slug AS category_slug
                FROM posts p LEFT JOIN categories c ON c.id = p.category_id
                WHERE p.visible = 1 AND p.published_at IS NOT NULL';
        if ($categoryId) {
            $sql .= ' AND p.category_id = ?';
            $params[] = $categoryId;
        }
        $sql .= ' ORDER BY p.published_at DESC';
        if ($limit > 0) {
            $sql .= ' LIMIT ' . (int) $limit;
        }
        return Database::all($sql, $params);
    }

    public static function post($slug)
    {
        return Database::first(
            'SELECT p.*, c.name AS category_name, c.slug AS category_slug
             FROM posts p LEFT JOIN categories c ON c.id = p.category_id
             WHERE p.slug = ? AND p.visible = 1',
            [$slug]
        );
    }

    public static function relatedPosts($post, $limit = 3)
    {
        $rows = Database::all(
            'SELECT p.*, c.slug AS category_slug FROM posts p
             LEFT JOIN categories c ON c.id = p.category_id
             WHERE p.visible = 1 AND p.id <> ? AND p.category_id = ?
             ORDER BY p.published_at DESC LIMIT ' . (int) $limit,
            [$post['id'], $post['category_id']]
        );
        if (count($rows) < $limit) {
            $extra = Database::all(
                'SELECT p.*, c.slug AS category_slug FROM posts p
                 LEFT JOIN categories c ON c.id = p.category_id
                 WHERE p.visible = 1 AND p.id <> ?
                 ORDER BY p.published_at DESC LIMIT ' . (int) ($limit * 2),
                [$post['id']]
            );
            $seen = [];
            foreach ($rows as $r) {
                $seen[$r['id']] = true;
            }
            foreach ($extra as $r) {
                if (count($rows) >= $limit) {
                    break;
                }
                if (!isset($seen[$r['id']])) {
                    $rows[] = $r;
                    $seen[$r['id']] = true;
                }
            }
        }
        return $rows;
    }

    public static function categories()
    {
        return Database::all('SELECT * FROM categories ORDER BY sort_order, id');
    }

    public static function category($slug)
    {
        return Database::first('SELECT * FROM categories WHERE slug = ?', [$slug]);
    }

    public static function menu($location)
    {
        return Database::all(
            'SELECT * FROM menu_items WHERE location = ? AND visible = 1 ORDER BY sort_order, id',
            [$location]
        );
    }

    public static function redirect($path)
    {
        return Database::first('SELECT * FROM redirects WHERE source = ?', [$path]);
    }
}
