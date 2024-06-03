<?php

namespace App\Http\Requests\Tag;

use App\Models\Tag;
use Illuminate\Foundation\Http\FormRequest;

class TagUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        $tagId = $this->route('tagId');
        if (Tag::find($tagId)) {
            return [
                'tag_name' => 'required|string|max:75|unique:tags,tag_name,' . $tagId,
            ];
        }
        return [];
    }
}
