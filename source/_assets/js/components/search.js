import fuse from 'fuse.js'

export default {
    fuse: null,
    searching: false,
    query: '',
    init() {
        fetch('/index.json')
            .then(response => response.json())
            .then(json => {
                this.fuse = new fuse(json, {
                    minMatchCharLength: 6,
                    keys: ['title', 'snippet', 'categories'],
                })
            })
    },
    results() {
        return this.query ? this.fuse.search(this.query) : []
    },
    showInput() {
        this.searching = true
        this.$nextTick(() => {
            this.$refs.search.focus()
        })
    },
    reset() {
        this.query = ''
        this.searching = false
    },
}
