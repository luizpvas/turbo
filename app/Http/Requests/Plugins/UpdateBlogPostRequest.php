<?php

namespace App\Http\Requests\Plugins;

use App\Models\Plugins\BlogPost;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBlogPostRequest extends FormRequest
{
    /**
     * Returns the blog post for this request.
     *
     * @return App\Models\Plugins\BlogPost
     */
    function blogPost()
    {
        return once(function () {
            return BlogPost::findOrFail($this->route('blog_post'));
        });
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->blogPost());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'        => 'sometimes|required',
            'body_html'    => 'sometimes|required',
            'body_text'    => 'sometimes|required',
            'published_at' => 'nullable'
        ];
    }
}
