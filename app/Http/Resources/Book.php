<?php

declare(strict_types=1);

namespace App\Http\Resources;

class Book extends Base
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array<string,mixed>
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'author'      => $this->author,
            'markdown'    => $this->markdown,
            'html'        => $this->html,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
            'deleted_at'  => $this->deleted_at,
        ];
    }
}
