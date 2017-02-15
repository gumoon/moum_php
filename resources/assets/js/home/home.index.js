Vue.component('example', require('../components/Example.vue'));

Vue.component('todo-item', {
	props: ['todo'],
	template: '<li>{{ todo.text }}</li>'
})

const app = new Vue({
    el: '#app',
    data: {
    	message: 'Hello Vue!',
    	seen: false,
    	todos: [
    		{text: 'Learn JavaScript'},
    		{text: 'Learn Vue?'},
    		{text: 'Build something awesome'}
    	]
    },
    methods: {
    	clickTodo: function(){
    		this.message = "hello,world!"
    	}
    }
});
