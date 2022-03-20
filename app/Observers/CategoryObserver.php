<?php

namespace App\Observers;

use App\Models\Article;
use Artisan;

class CategoryObserver extends BaseObserver
{
    /**
     * @param \App\Models\Category $model
     */
    public function created($model)
    {
        parent::created($model);

        Artisan::queue('bjyblog:generate-sitemap');
    }

    /**
     * @param \App\Models\Category $category
     */
    public function saving($category)
    {
        if ($category->isDirty('name') && empty($category->slug)) {
            $category->slug = generate_english_slug($category->name);
        }
        return true;
    }

    /**
     * @param \App\Models\Category $category
     */
    public function deleting($category)
    {
        if (Article::where('category_id', $category->id)->count() !== 0) {
            flash_error('请先删除此分类下的文章');
            return false;
        }
    }

    /**
     * @param \App\Models\Category $model
     */
    public function deleted($model)
    {
        parent::deleted($model);

        if (! $model->isForceDeleting()) {
            Artisan::queue('bjyblog:generate-sitemap');
        }
    }
}
