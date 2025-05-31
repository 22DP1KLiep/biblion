<template>
    <div v-if="!$page.props.auth.user">
        <p>You are a guest. Please log in.</p>
    </div>
</template>
