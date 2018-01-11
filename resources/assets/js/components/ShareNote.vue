<template>
        <div class="panel-body">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ title }}</h4>
                    <p class="card-text "><xmp style="white-space: pre-wrap">{{ body }}</xmp></p>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
 export default {
        props: [
            'note',
        ],

        data() {
            return {
                title: this.note.title,
                body: this.note.body,
                user_id: this.note.user_id,
                status: ''
            }
        }
    }
</script>