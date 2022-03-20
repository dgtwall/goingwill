<?php

declare(strict_types=1);

namespace App\Models;

use Exception;
use Laravel\Scout\Searchable;
use Overtrue\LaravelFollow\Traits\CanBeLiked;
use Str;

/**
 * Class Book
 *
 * @property int                             $id          文章表主键
 * @property string                          $title       标题
 * @property string                          $author      作者
 * @property string                          $markdown    markdown文章内容
 * @property string                          $html        markdown转的html页面
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read mixed $url
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base disableCache()
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|\App\Models\Book newModelQuery()
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|\App\Models\Book newQuery()
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|\App\Models\Book query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Book whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Book whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Book whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Book whereHtml($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Book whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Book whereMarkdown($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Book whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Book whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base withCacheCooldownSeconds($seconds = null)
 * @mixin \Eloquent
 */
class Book extends Base
{
    use Searchable, CanBeLiked;

    /**
     * @return array<string,mixed>
     */
    public function toSearchableArray(): array
    {
        return $this->only('id', 'title', 'markdown');
    }

    public function getHtmlAttribute(string $value): string
    {
        return str_replace('<img src="/uploads/book', '<img src="' . cdn_url('uploads/book'), $value);
    }

    /**
     * @return array<int,int>
     */
    public static function getIdsGivenSearchWord(string $wd): array
    {
        if (trim($wd) === '') {
            return [];
        }

        // 如果 SCOUT_DRIVER 为 null 则使用 sql 搜索
        if (Str::isNull(config('scout.driver'))) {
            return self::where('title', 'like', "%$wd%")
                ->orWhere('markdown', 'like', "%$wd%")
                ->pluck('id')
                ->toArray();
        }

        // 如果全文搜索出错则降级使用 sql like
        try {
            $ids = self::search($wd)->keys()->toArray();
        } catch (Exception $e) {
            $ids = self::where('title', 'like', "%$wd%")
                ->orWhere('markdown', 'like', "%$wd%")
                ->pluck('id')
                ->toArray();
        }

        return $ids;
    }

    public function getUrlAttribute(): string
    {
        $parameters = [$this->id];

        if (Str::isTrue(config('bjyblog.seo.use_slug'))) {
            $parameters[] = $this->slug;
        }

        return url('book', $parameters);
    }
}
