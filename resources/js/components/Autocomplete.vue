<template>
    <section>
        <b-field :label="title">
            <b-autocomplete
                v-model="name"
                clear-on-select
                :data="filteredDataArray"
                :open-on-focus="true"
                :placeholder="placeholder"
                icon="magnify"
                @select="$emit('change', $event)">
                <template slot="empty">No results found</template>
            </b-autocomplete>
        </b-field>
    </section>
</template>

<script>
    export default {
        props: [
          'values',
          'searchPath',
          'placeholder',
          'title',
          'resource'
        ],
        data() {
            return {
                data: [],
                name: '',
                selected: null
            }
        },
        created() {
            this.searchPath = this.searchPath || 'name';

            if(!this.values && this.resource) {
                this.getItemsFromResource();
            } else {
                this.data = this.values;
            }
        },
        computed: {
            filteredDataArray() {
                return this.data.filter((option) => {
                    return _.get(option, this.searchPath)
                            .toString()
                            .toLowerCase()
                            .indexOf(this.name.toLowerCase()) >= 0
                })
            }
        },
        methods: {
            getItemsFromResource() {
                axios.get(this.resource)
                    .then(response => {
                        this.data = response.data;
                    });
            }
        }
    }
</script>
