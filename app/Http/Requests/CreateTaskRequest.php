<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\NoRestrictedWords;

class CreateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
        // true - daca toti utilizatorii sunt autorizati
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => ['nullable', 'string', new NoRestrictedWords],
            // 'deadline' => 'nullable|date',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id', 
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Titlul este obligatoriu.',
            'title.max' => 'Titlul nu poate avea mai mult de 255 de caractere.',
            'category_id.required' => 'Categoria este obligatorie.',
            'category_id.exists' => 'Categoria selectată nu există.',
            'tags.*.exists' => 'Eticheta selectată nu este validă.',
            'description.no_restricted_words' => 'Descrierea conține cuvinte interzise.',
        ];
    }
}

