<template>
    <div>
        <div class="field is-horizontal">
            <div class="field-body">
                <b-field>
                    <b-input placeholder="Name..."
                             type="text"
                             min="5"
                             v-model="clientObj.name"
                             icon-pack="fas"
                             icon="user">
                    </b-input>
                </b-field>
                <b-field>
                    <b-input placeholder="Email"
                             type="email"
                             v-model="clientObj.email"
                             icon="email">
                    </b-input>
                </b-field>
            </div>
        </div>

        <div class="field is-horizontal">
            <div class="field-body">
                <div class="field is-expanded">
                    <div class="field has-addons">
                        <p class="control">
                            <a class="button is-static">
                                #
                            </a>
                        </p>
                        <p class="control is-expanded">
                            <input class="input" type="number" min="5" placeholder="Your phone number" v-model="clientObj.phone">
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <p class="help is-danger" v-for="e in this.errors">
            {{ e[0] }}
        </p>
        <div class="columns" v-if="editMode">
            <div class="column is-one-fifth">
                <a class="button is-link" @click="saveClient">Save</a>
                <a class="button is-danger" @click="deleteClient">Delete</a>
            </div>
            <div class="column"></div>
            <div class="column"></div>
        </div>
    </div>
</template>

<script>

    import ClientService from "../Services/ClientService";

    export default {
        name: "ClientForm",
        props: [
            'client',
        ],
        data() {
            return {
                clientObj: {
                    id: 0,
                    name: '',
                    phone: '',
                    email: ''
                },
                errors: []
            }
        },
        computed: {
            editMode() {
                return this.clientObj || !this.id;
            }
        },
        methods: {
            deleteClient() {
                this.$emit('delete');
            },
            saveClient() {
                this.errors= [];
                ClientService.save(this.clientObj)
                    .then(data => this.$emit('save', data))
                    .catch(response => {
                        if(response.errors) {
                            this.errors = response.errors;
                        }
                    });
            }
        },
        created() {
        }
    }
</script>
