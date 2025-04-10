<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
         // 商品IDを取得（更新時のみ存在する）
        $productId = $this->route('productId');

        // 基本ルールを定義
        $rules = [
            'name' => 'required',
            'price' => 'required|numeric|min:0|max:10000',
            'seasons' => 'required',
            'description' => 'required|max:120',
        ];

        // 商品作成時は画像必須、更新時は画像がある場合のみバリデーション
        if (!$productId) {
            // 新規作成時
            $rules['image'] = 'required|mimes:png,jpeg,jpg';
        } else {
            // 更新時（画像がある場合のみ）
            $rules['image'] = 'nullable|mimes:png,jpeg,jpg';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',
            'price.required' => '値段を入力してください',
            'price.numeric' => '数値で入力してください',
            'price.min' => '0~10000円以内で入力してください',
            'price.max' => '0~10000円以内で入力してください',
            'seasons.required' => '季節を選択してください',
            'description.required' => '商品説明を入力してください',
            'description.max' => '120文字以内で入力してください',
            'image.required' => '商品画像を登録してください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
        ];
    }
}
