<style scoped>
    .action-link {
        cursor: pointer;
    }

    .image-thumb, .image-thumb img {
        position:relative;
        width:60px;
        height:50px;
    }

    .image-fav {
        display:none;
        position:absolute;
        bottom:0;
        left:0;
        width:15px;
        height:15px;
        background-image:url(normal_plus.png);
    }

    .image-thumb:hover .image-fav {
        display:block;
    }

    .image-fav:hover {
        background-image:url(hover_plus.png);
    }
</style>

<template>
    <div class="image-thumb">
        <img src="thumb.jpg" />
    <a href="#" class="image-fav"></a>
</div>
</template>

<script>
    export default {
        props: [''],
        data() {
            return {

            };
        },

        mounted() {

        },

        methods: {

        }
    }
</script>
