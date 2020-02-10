<template>
    <div class="card col-md-6 offset-3 mt-1" style="position:relative">
        <div class="card-header h1">Todo List</div>
        <div class="card-body">
            <div class="loader" v-if="loading"></div>
            <form class="form-inline" @submit.prevent="addNewTodo">
                <div class="input-group w-100">
                    <input class="form-control-lg" type="text" autofocus placeholder="Type..." v-model="input" style="width: 85%">
                    <span class="input-group-btn">
                        <button class="btn btn-primary btn-lg" type="submit">Add</button>
                    </span>
                </div>
            </form>
            <div class="form-group mt-4 text-center">
                <button v-for="button in buttons" class="btn" :class="{'btn-primary':button.id===activeButton,'btn-outline-primary':button.id!==activeButton,}" @click="changeType(button)">
                    {{button.text}}
                </button>
            </div>
            <ul>
                <li v-for="todo in filteredTodos">
                    <label class="todo" @click="toggle(todo)">
                        <del v-if="todo.done">
                            {{ todo.text }}
                        </del>
                        <span v-else>
                            {{ todo.text }}
                        </span>
                    </label>
                    <button @click="deleteTodo(todo)" class="btn btn-danger">
                        X
                    </button>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                input:"",
                todos:[],
                search:"",
                loading:true,
                activeButton:0,
                buttons:[
                    {text:"All",id:0},
                    {text:"Done",id:1},
                    {text:"Not Done",id:2},
                ],
            }
        },
        created(){
            window.EventBus.$on('search',(text)=>{
                this.search=text;
            });
        },
        mounted(){
            let _this=this;
            axios.get("https://todoapp.spider/api/todo")
                .then(response=>{
                    _this.todos=response.data;
                })
                .catch(function (error) {
                    console.log(error);
                })
                .then(()=>{
                    _this.loading=false;
                });
        },
        methods: {
            addNewTodo(){
                if(this.input!==""){
                    this.loading=true;
                    let _this=this;
                    axios.post("https://todoapp.spider/api/todo/",{
                        "done":false,
                        "text":_this.input
                    })
                        .then(response=>{
                            _this.todos.push(response.data);
                            _this.input="";
                            _this.loading = false;
                            _this.search="";
                            if(_this.activeButton===1)
                                _this.activeButton=2;
                        })
                        .catch(function (error) {
                            console.log(error);
                        })
                        .then(()=>{
                            _this.loading=false;
                        });
                }
            },
            deleteTodo(todo){
                this.loading=true;
                let _this=this;
                axios.delete("https://todoapp.spider/api/todo/"+todo.id)
                    .then(reponse=>{
                        _this.todos=_this.todos.filter(t=>t.id!==todo.id);
                        _this.loading = false;
                    }).catch(error=>{
                        console.log(error);
                    }).then(()=>{
                        _this.loading=false;
                        _this.search="";
                    });
            },
            toggle: function(todo){
                if(!this.loading){
                    this.loading=true;
                    fetch("https://todoapp.spider/api/todo/"+todo.id,{
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            "done":!todo.done
                        }),
                    })
                        .then(r=>r.json())
                        .then(response=>{
                            todo.done = response.done;
                            this.loading = false;
                        });
                }
            },
            changeType(button){
                this.activeButton=button.id;
            }
        },
        computed:{
            filteredTodos(){
                return this.todos.filter(todo=> {
                    if ((this.activeButton === 1 && !todo.done) || (this.activeButton===2 && todo.done)) return false;
                    return todo.text.toLowerCase().includes(this.search.toLowerCase())
                });
            }
        }
    }
</script>

<style scoped>
    .todo{
        font-size:24px;
    }
    .loader {
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        animation: spin 0.5s linear infinite;
        position: absolute;
        top: 30px;
        right: 30px;
    }
    input[type=checkbox] {
        display: none;
    }
</style>
