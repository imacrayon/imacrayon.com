import fuse from 'fuse.js'

export default {
  fuse: null,
  searching: false,
  query: '',
  results: [],
  selected: null,
  activeDescendant: '',
  init() {
    fetch('/index.json')
      .then(response => response.json())
      .then(json => {
        this.fuse = new fuse(json, {
          minMatchCharLength: 6,
          keys: ['title', 'snippet', 'categories'],
        })
      })
    this.$watch('selected', value => {
      if (!this.searching) return

      if (this.selected === null) {
        this.activeDescendant = ''
        return
      }

      this.activeDescendant = this.getItemId(this.selected)
    })
  },
  showInput() {
    this.searching = true
    this.$nextTick(() => {
      this.$refs.search.focus()
    })
  },
  search() {
    this.results = this.query
      ? this.fuse.search(this.query).map(({ item }) => item)
      : []
  },
  choose(result) {
    window.location = result.link
    this.reset()
  },
  onArrowUp() {
    if (!this.results.length) return
    this.selected =
      this.selected - 1 < 1 ? this.results.length : this.selected - 1
    this.scrollTo(this.selected - 1)
  },
  onArrowDown() {
    if (!this.results.length) return
    this.selected =
      this.selected + 1 > this.results.length ? 1 : this.selected + 1
    this.scrollTo(this.selected - 1)
  },
  onEnter() {
    if (!this.results.length) return
    if (this.selected) {
      return this.choose(this.results[this.selected - 1])
    }
    this.reset()
  },
  reset() {
    this.query = ''
    this.searching = false
  },
  scrollTo(index) {
    const childOffset = 2
    this.$refs.listbox.children[index + childOffset].scrollIntoView({
      block: 'nearest',
    })
  },
  getItemId(index) {
    return `result-item-${index}`
  },
  isSelected(index) {
    return index === this.selected - 1
  },
}
