import hljs from 'highlight.js/lib/highlight'
import hljsVue from 'highlightjs-vue'
import 'alpinejs'
import Search from './components/search'

window.components = {
    search: () => Search,
}

// Syntax highlighting
hljs.registerLanguage('bash', require('highlight.js/lib/languages/bash'))
hljs.registerLanguage('css', require('highlight.js/lib/languages/css'))
hljs.registerLanguage('html', require('highlight.js/lib/languages/xml'))
// prettier-ignore
hljs.registerLanguage('javascript', require('highlight.js/lib/languages/javascript'))
hljs.registerLanguage('json', require('highlight.js/lib/languages/json'))
// prettier-ignore
hljs.registerLanguage('markdown', require('highlight.js/lib/languages/markdown'))
hljs.registerLanguage('php', require('highlight.js/lib/languages/php'))

hljsVue(hljs)

document.querySelectorAll('pre code').forEach(block => {
    hljs.highlightBlock(block)
})
