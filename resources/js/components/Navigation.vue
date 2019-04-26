<script>
    import Vue2Filters from 'vue2-filters'

    export default {
        name: "Navigation",
        props: ['tab'],
        mixins: [Vue2Filters.mixin],
        data() {
            return {
                tabs: [
                    'reservations',
                    'clients',
                    'rooms'
                ],
                burgerMenu: false
            }
        },
        methods: {
            selectTab(tab, e) {
                this.tabs.forEach(t => {
                    t.selected = (tab.name == t.name);
                });
            },
            getTabClasses(tab) {
                return ['navbar-item', tab == this.tab ? 'is-active' : ''];
            }
        }
    }
</script>
