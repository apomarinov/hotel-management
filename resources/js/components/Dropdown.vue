<template>
    <b-dropdown aria-role="list" :bind="model" @change="updateModel($event)" v-if="items">
        <button :class="classes()" slot="trigger">
            <span>{{ selected.id ? selected[optionName] : name }}</span>
            <b-icon icon="menu-down"></b-icon>
        </button>

        <b-dropdown-item aria-role="listitem" v-for="i in items" :key="i[valueName]" :value="i">
            {{ i[optionName] }}
        </b-dropdown-item>
    </b-dropdown>
</template>

<script>
    export default {
        props: [
            'color',
            'name',
            'model',
            'values',
            'resource',
            'icon',
            'noDefault',
            'valueName',
            'optionName'
        ],
        data() {
          return {
              defaultOption: {},
              items: [],
              selected: {}
          }
        },
        created() {
            this.defaultOption = {};
            this.defaultOption[this.valueOption || 'id'] = 0;
            this.defaultOption[this.optionName || 'value'] = 'None';

            if(!this.values) {
                if(this.resource) {
                    this.getItemsFromResource();
                }
            } else {
                this.items = this.values;
                if(!this.noDefault) {
                    this.items.unshift(this.defaultOption);
                }
            }
            this.selected = this.model || {};
        },
        methods: {
            classes() {
                return ['button', this.color];
            },
            updateModel(selected) {
                this.selected = selected;
                this.$emit('change', selected);
            },
            getItemsFromResource() {
                axios.get(this.resource)
                    .then(response => {
                        this.items = response.data;

                        if(!this.noDefault) {
                            this.items.unshift(this.defaultOption);
                        }
                    });
            }
        }
    }
</script>
