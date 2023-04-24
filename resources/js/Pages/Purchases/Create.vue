<script setup>
// /resources/js/Pages/Dashboard.vueのコピー
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { onMounted, reactive, ref, computed } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { getToday } from "@/common";
// import BreezeValidationErrors from "@/Components/BreezeValidationErrors.vue";
import MicroModal from "@/Components/ MicroModal.vue";


// reactiveで
const form = reactive({
    // (購入日) dateの情報をformの情報に登録
    date: null,
    // (会員名) customer_idの情報をformの情報に登録
    customer_id: null,
    // (商品・サービス) item_idの情報をformの情報に登録
    status: true,
    // (商品・サービス) item_idの情報をformの情報に登録
    items: [],
});
//する

// definePropsで
const props = defineProps({
    // errors: Object,
    // ControllerのCreateメソッドから、Inertia::renderでView（Create）に渡した
    // customers取得
    customers: Array,
    // items取得
    items: Array,
});

// propsのままだと変更できないので新たに配列を作って追加
// リアクティブな配列を準備
const itemList = ref([]);

//VueのonMounted機能で、ページ読み込み後 即座に実行
onMounted(() => {
    // form.dateに今日の日付を入れる
    form.date = getToday();
    // form.customer_idに1を入れる
    props.items.forEach((item) => {
        // 配列を1つずつ処理
        itemList.value.push({
            // 配列に1つずつ追加
            id: item.id,
            name: item.name,
            price: item.price,
            quantity: 0,
        });
    });
});

// option用の配列
const quantity = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];

// computedでitemListの合計金額を算出(リアルタイムの変更の表示に向いている)
const totalPrice = computed(() => {
    // itemListの合計金額を算出
    return itemList.value.reduce((total, item) => {
        // itemListの合計金額を算出
        return total + item.price * item.quantity;
    }, 0);
});
 

const storePurchase = () => {
    itemList.value.forEach((item) => {
        if (item.quantity > 0)
            // 0より大きいものだけ追加
            form.items.push({ id: item.id, quantity: item.quantity });
    });
    Inertia.post(route("purchases.store"), form);
};

const setCustomerId = (id) => {
    form.customer_id = id;
};
</script>

<template>
    <!-- /resources/js/Pages/Dashboard.vueのコピー -->

    <Head title="購入画面" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                購入画面
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <!-- エラーの出力（コンポーネントをしようしてまとめて出力） -->
                    <!-- <BreezeValidationErrors :errors="errors" /> -->
                    <section class="text-gray-600 body-font relative">
                        <form @submit.prevent="storePurchase">
                            <div class="container px-5 py-8 mx-auto">
                                <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                    <div class="flex flex-wrap -m-2">
                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label
                                                    for="date"
                                                    class="leading-7 text-sm text-gray-600"
                                                    >日付</label
                                                >
                                                <input
                                                    type="date"
                                                    id="date"
                                                    name="date"
                                                    v-model="form.date"
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                />
                                            </div>
                                        </div>
                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label
                                                    for="customer"
                                                    class="leading-7 text-sm text-gray-600"
                                                    >会員名</label
                                                >
                                                <MicroModal @update:customer-id="setCustomerId" />
                                            </div>
                                        </div>
                                        <div
                                            class="w-full py-8 mx-auto overflow-auto"
                                        >
                                            <table
                                                class="table-auto w-full text-left whitespace-no-wrap"
                                            >
                                                <thead>
                                                    <tr>
                                                        <th
                                                            class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                                                        >
                                                            id
                                                        </th>
                                                        <th
                                                            class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                                                        >
                                                            商品名
                                                        </th>
                                                        <th
                                                            class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                                                        >
                                                            価格
                                                        </th>
                                                        <th
                                                            class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                                                        >
                                                            数量
                                                        </th>
                                                        <th
                                                            class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                                                        >
                                                            小計
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!--　v-forで情報を繰り返し表示 -->
                                                    <tr
                                                        v-for="item in itemList"
                                                        :key="item.id"
                                                    >
                                                        <td
                                                            class="border-b-2 border-gray-200 px-4 py-3"
                                                        >
                                                            {{ item.id }}
                                                        </td>
                                                        <td
                                                            class="border-b-2 border-gray-200 px-4 py-3"
                                                        >
                                                            {{ item.name }}
                                                        </td>
                                                        <td
                                                            class="border-b-2 border-gray-200 px-4 py-3"
                                                        >
                                                            {{ item.price }}
                                                        </td>
                                                        <td
                                                            class="border-b-2 border-gray-200 px-4 py-3"
                                                        >
                                                            <select
                                                            class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-30 leading-8 transition-colors duration-200 ease-in-out"
                                                                name="quantity"
                                                                v-model="
                                                                    item.quantity
                                                                "
                                                            >
                                                                <option
                                                                    v-for="q in quantity"
                                                                    :value="q"
                                                                >
                                                                    {{ q }}
                                                                </option>
                                                            </select>
                                                        </td>
                                                        <td
                                                            class="border-b-2 border-gray-200 px-1 py-3 my-3"
                                                        >
                                                            {{ item.price * item.quantity }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="p-2 w-full">
                                            <div class="">
                                                <label
                                                    for="date"
                                                    class="leading-7 text-sm text-gray-600"
                                                    >合計金額</label
                                                >
                                                <div class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    {{ totalPrice }}円
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-2 w-full">
                                            <button
                                                class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"
                                            >
                                                商品登録
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
