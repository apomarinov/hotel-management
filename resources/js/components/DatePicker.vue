<template>
    <b-field v-bind:label="name">
        <b-datepicker
            placeholder="Select a date..."
            icon="calendar-today"
            :min-date="currentMinDate"
            :max-date="currentMaxDate"
            @input="change($event)">
        </b-datepicker>
    </b-field>
</template>

<script>
    export default {
        props: [
            'name',
            'id',
            'min',
            'fromId',
            'toId'
        ],
        data() {
          return {
              minDate: new Date(-8640000000000000),
              maxDate: new Date(8640000000000000),
              currentMinDate: {},
              currentMaxDate: {},
          }
        },
        created() {
            this.currentMinDate = this.minDate;
            this.currentMaxDate = this.maxDate;

            if(this.min) {
                this.currentMinDate = this.min;
                this.currentMinDate = this.currentMinDate.addDays(-1);
            }

            let connectedPickerId = this.fromId || this.toId;
            if(connectedPickerId) {
                Event.$on(`datepicker.${connectedPickerId}.change`, this.handleConnectedPickerChange);
            }
        },
        methods: {
            change(selected) {
                this.$emit('change', selected);
                Event.$emit(`datepicker.${this.id}.change`, selected);
            },
            handleConnectedPickerChange(date) {
                if(this.fromId) {
                    this.currentMinDate = date || this.minDate;
                    this.currentMinDate = this.currentMinDate.addDays(1);
                }
                if(this.toId) {
                    this.currentMaxDate = date || this.maxDate;
                }
            }
        }
    }
</script>
