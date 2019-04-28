<template>
    <div class="box">
        <div class="columns">
            <div class="column"><strong>{{ client.name }}</strong></div>
            <div class="column"><i class="fas fa-phone"></i>&nbsp;+{{ client.phone }}</div>
            <div class="column">{{ client.email }}</div>
            <div class="column is-1">
                <a class="level-item" @click="$emit('interact', client.id)">
                    <span class="icon is-medium">
                      <i :class="icon" aria-hidden="true"></i>
                    </span>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Client",
        props: [
            'client',
            'icon'
        ]
    }
</script>
