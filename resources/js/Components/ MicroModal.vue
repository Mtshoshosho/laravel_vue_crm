<script setup>
import { ref, onMounted, reactive } from "vue";
import axios from "axios";

const isShow = ref(false);
const toggleStatus = () => {
    isShow.value = !isShow.value;
};
// onMounted(() => {
//     // axiosの動作確認
//     axios.get("/api/user").then((response) => {
//         console.log(response.data);
//     });
// });

const search = ref("");
const customers = reactive({});
const searchCustomers = async () => {
    try {
        await axios
            .get(`/api/searchCustomers/?search=${search.value}`)
            .then((res) => {
                console.log(res.data);
                customers.value = res.data;
            });
        toggleStatus();
    } catch (e) {
        console.log(e.message);
    }
};

// Emitで親コンポーネントに値を渡す
const emit = defineEmits(["update:customerId"]);

 
const setCustomer = (e) => {
    search.value = e.kana;
    emit('update:customerId', e.id)
    toggleStatus();
};
</script>

<template>
    <div v-show="isShow" class="modal" id="modal-1" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
            <div
                class="modal__container w-2/3"
                role="dialog"
                aria-modal="true"
                aria-labelledby="modal-1-title"
            >
                <header class="modal__header">
                    <h2 class="modal__title" id="modal-1-title">顧客検索</h2>
                    <button
                        type="button"
                        class="modal__close"
                        aria-label="Close modal"
                        data-micromodal-close
                        @click="toggleStatus"
                    ></button>
                </header>
                <main class="modal__content" id="modal-1-content">
                    <div
                        v-if="customers.value"
                        class="lg:w-2/3 w-full mx-auto overflow-auto"
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
                                        氏名
                                    </th>
                                    <th
                                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                                    >
                                        カナ
                                    </th>
                                    <th
                                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                                    >
                                        電話番号
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- 　v-forで情報を繰り返し　objectで渡ってきた、customersのdataを表示  -->
                                <tr
                                    v-for="customer in customers.value.data"
                                    :key="customers.id"
                                >
                                    <td
                                        class="border-b-2 border-gray-200 px-4 py-3"
                                    >
                                        <button
                                            type="button"
                                            class="text-indigo-500 hover:text-indigo-600"
                                            @click="
                                                setCustomer({
                                                    id: customer.id,
                                                    name: customer.name,
                                                    kana: customer.kana,
                                                    tel: customer.tel,
                                                })
                                            "
                                        >
                                            {{ customer.id }}
                                        </button>
                                    </td>
                                    <td
                                        class="border-b-2 border-gray-200 px-4 py-3"
                                    >
                                        {{ customer.name }}
                                    </td>
                                    <td
                                        class="border-b-2 border-gray-200 px-4 py-3"
                                    >
                                        {{ customer.kana }}
                                    </td>
                                    <td
                                        class="border-b-2 border-gray-200 px-4 py-3"
                                    >
                                        {{ customer.tel }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </main>
                <footer class="modal__footer">
                    <button
                        type="button"
                        class="modal__btn"
                        data-micromodal-close
                        aria-label="Close this dialog window"
                        @click="toggleStatus"
                    >
                        閉じる
                    </button>
                </footer>
            </div>
        </div>
    </div>
    <div class="flex pr-4 pb-4">
        <input
            name="customer"
            v-model="search"
            class="w-55 h-8 bg-gray-100 bg-opacity-50 rounded-l border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
        />
        <button
            @click="searchCustomers"
            type="button"
            data-micromodal-trigger="modal-1"
            class="w-25 h-8 text-white bg-indigo-500 border-0 px-3 focus:outline-none hover:bg-indigo-600 rounded-r text-lg"
        >
            検索
        </button>
    </div>
</template>
