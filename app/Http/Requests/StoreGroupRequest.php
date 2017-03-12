<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Setting;

class StoreGroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $term = Setting::first()->term_id;

        $this['term'] = $term;

        $slug = $this->subject . '-' . $this->section . '-' . $term;
        
        $this['slug'] = $slug; 

        return [
            'subject'  => 'required|alpha_dash|max:10',
            'section'  => 'required|alpha|max:3',
            'room'     => 'required',
            'schedule' => 'required',
            'start'    => 'required',
            'end'      => 'required',
        ];
    }

}
