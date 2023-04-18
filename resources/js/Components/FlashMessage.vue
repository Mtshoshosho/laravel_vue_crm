<script setup>

</script>

<template>
    <!-- フラッシュメッセージ -->
    <!-- successの場合 -->
    <div v-if="$page.props.flash.status === 'success'" class="bg-blue-300 text-white p-4">
        {{ $page.props.flash.message }}
    </div>
    <!-- dangerの場合 -->
    <div v-if="$page.props.flash.status === 'danger'" class="bg-red-300 text-white p-4">
        {{ $page.props.flash.message }}
    </div>
</template>