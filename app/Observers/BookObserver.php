<?php

namespace App\Observers;

use Artisan;
use Markdown;
use Str;

class BookObserver extends BaseObserver
{
    /**
     * @param \App\Models\Book $book
     */
    public function created($book)
    {
        parent::created($book);

        Artisan::queue('bjyblog:generate-sitemap');
    }

    /**
     * @param \App\Models\Book $book
     */
    public function saving($book)
    {
        $book->html = Markdown::convertToHtml($book->markdown);
        $image_paths = get_image_paths_from_html($book->html);

        foreach ($image_paths as $image_path) {
            if (function_exists('imagettfbbox') && file_exists(public_path($image_path))) {
                watermark($image_path, config('bjyblog.water.text'));
            }
        }
    }

    /**
     * @param \App\Models\Book $book
     */
    public function updated($book)
    {
        parent::updated($book);
    }

    /**
     * @param \App\Models\Book $book
     */
    public function deleted($book)
    {
        if ($book->isForceDeleting()) {
            flash_success('彻底删除成功');
        } else {
            Artisan::queue('bjyblog:generate-sitemap');
            flash_success('删除成功');
        }
    }

    /**
     * @param \App\Models\Book $book
     */
    public function restored($book)
    {
        flash_success('恢复成功');
    }
}
