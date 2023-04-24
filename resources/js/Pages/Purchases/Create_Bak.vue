<script setup>
import { getToday } from "@/common";
import { onMounted, reactive, ref, computed } from "vue";
import { Inertia } from "@inertiajs/inertia";

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
</script>

<template>
    <form @submit.prevent="storePurchase">
        <!--購入日-------------------------------------------------------------------------------- -->
        日付<br />
        <input type="date" name="date" v-model="form.date" /><br />
        <!--会員名-------------------------------------------------------------------------------- -->
        会員名<br />
        <select name="customer" v-model="form.customer_id">
            <option
                v-for="customer in customers"
                :value="customer.id"
                :key="customer.id"
            >
                {{ customer.id }} : {{ customer.name }}
            </option>
        </select>
        <!--商品情報-------------------------------------------------------------------------------- -->
        商品・サービス<br />
        <table>
            略
            <tbody>
                <tr v-for="item in itemList">
                    <td>{{ item.id }}</td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.price }}</td>
                    <td>
                        <select name="quantity" v-model="item.quantity">
                            <option v-for="q in quantity" :value="q">
                                {{ q }}
                            </option>
                        </select>
                    </td>
                    <td>
                        {{ item.price * item.quantity }}
                    </td>
                </tr>
            </tbody>
        </table>
        <br />
        <!--合計金額-------------------------------------------------------------------------------- -->
        合計 {{ totalPrice }} 円<br />
        <button>登録</button>
    </form>
</template>
