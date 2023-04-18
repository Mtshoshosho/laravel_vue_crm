<script setup>
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'

defineProps({
    errors: Object
})

const form = reactive({
    title: null,
    content: null
})
const submitFunction = () => {
    Inertia.post('/inertia', form)
}
</script>  

<!-- <script setup>:
この部分では、Vue.jsの機能とInertia.jsの機能をインポートし、フォームデータと送信処理のロジックを定義しています。
import { reactive } from 'vue': Vue.jsからreactive関数をインポートします。これは、リアクティブなオブジェクトを作成するために使用されます。
import { Inertia } from '@inertiajs/inertia': Inertia.jsからInertiaオブジェクトをインポートします。これは、ページ遷移やデータ送信に使用されます。
const form = reactive({ title: null, content: null }): リアクティブなformオブジェクトを作成し、初期値をnullに設定します。これにより、フォームの入力が変更されるたびにVue.jsが自動的に画面を更新します。
const submitFunction = () => { Inertia.post('/inertia', form) }: フォームの送信処理を行う関数submitFunctionを定義します。この関数は、Inertia.jsのpostメソッドを使って、/inertiaエンドポイントにフォームデータを送信します。 -->

<template>
    <!-- コンポーネントでまとめて出力 -->
    <BreezeValidationErrors :errors="errors" />
    <!-- 一つづつ出力 -->
    <form @submit.prevent="submitFunction">
        <input type="text" name="title" v-model="form.title">{{ form.title }}<br>
        <div v-if="errors.title">{{ errors.title }}</div><br>
        <input type="text" name="content" v-model="form.content">{{ form.content }}<br>
        <div v-if="errors.content">{{ errors.content }}</div><br>
        <button>送信</button>
    </form>
</template>

<!-- <template>:
この部分では、HTMLとVue.jsのディレクティブを使用してフォームの見た目を定義しています。
<form @submit.prevent="submitFunction">: フォーム要素を定義し、submitイベントのデフォルトの動作を防止する@submit.preventディレクティブを使って、送信時にsubmitFunctionを実行します。
<input type="text" name="title" v-model="form.title">: タイトル用のテキスト入力欄を作成し、v-modelディレクティブを使ってform.titleにバインドします。これにより、入力が変更されるたびにform.titleが更新されます。
<input type="text" name="content" v-model="form.content">: コンテンツ用のテキスト入力欄を作成し、v-modelディレクティブを使ってform.contentにバインドします。 -->