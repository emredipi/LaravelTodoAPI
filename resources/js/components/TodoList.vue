<template>
    <div class="card col-md-6 offset-md-3">
        <div class="card-header h1">Todo List</div>
        <div class="card-body">
            <div class="loader" v-if="loading"></div>
            <form class="form-inline" @submit.prevent="addNewTodo">
                <select class="form-control mb-2 w-100" v-model="currentTagID" @change="fetchTodos">
                    <option v-for="tag in tags" :value="tag.id">{{tag.name}}</option>
                </select>
                <div class="input-group w-100">
                    <input class="form-control-lg" type="text" autofocus placeholder="Type..." v-model="input" style="width: 85%">
                    <span class="input-group-btn" style="width: 15%;">
                        <button class="btn btn-primary btn-lg" type="submit">Add</button>
                    </span>
                </div>
            </form>
            <div class="btn-group mt-4 text-center w-100">
                <button v-for="button in buttons" class="btn" :class="{'btn-primary':button.id===activeButton,'btn-outline-primary':button.id!==activeButton}" @click="changeType(button)">
                    {{button.text}}
                </button>
            </div>
            <div class="mt-4 alert alert-warning h4" v-if="search" @click="search=''">
                Search filtered by: <b v-text="search" />
            </div>
            <ol class="mt-4">
                <li v-for="todo in filteredTodos" class="row">
                    <label class="todo col-10" @click="toggle(todo)">
                        <del v-if="todo.done">
                            {{ todo.text }}
                        </del>
                        <span v-else>
                            {{ todo.text }}
                        </span>
                    </label>
                    <div class="col-2">
                        <button @click="deleteTodo(todo)" class="btn btn-danger">
                            X
                        </button>
                    </div>
                </li>
            </ol>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                input:"",
                todos:[],
                tags:[],
                currentTagID:0,
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
            axios.get("tag")
                .then(response=>{
                    this.tags=response.data;
                    this.currentTagID=response.data[0].id;
                    this.fetchTodos();
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        methods: {
            addNewTodo(){
                if(this.input!==""){
                    this.loading=true;
                    axios.post("todo",{
                        "tag":this.currentTagID,
                        "done":false,
                        "text":this.input
                    })
                        .then(response=>{
                            this.todos.push(response.data);
                            this.input="";
                            this.loading = false;
                            this.search="";
                            if(this.activeButton===1)
                                this.activeButton=2;
                        })
                        .catch(function (error) {
                            console.log(error);
                        })
                        .then(()=>{
                            this.loading=false;
                        });
                }
            },
            deleteTodo(todo){
                this.loading=true;
                axios.delete("todo/"+todo.id)
                    .then(response=>{
                        this.todos=this.todos.filter(t=>t.id!==todo.id);
                        this.loading = false;
                    }).catch(error=>{
                        console.log(error);
                    }).then(()=>{
                        this.loading=false;
                        this.search="";
                    });
            },
            toggle(todo){
                if(!this.loading){
                    this.loading=true;
                    axios.put("todo/"+todo.id,{
                        "done":!todo.done
                    })
                        .then(response=>{
                            todo.done = response.data.done;
                            this.loading = false;
                        });
                }
            },
            fetchTodos(){
                axios.get("todo?tag="+this.currentTagID)
                    .then(response=>{
                        this.todos=response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
                    .then(()=>{
                        this.loading=false;
                    });
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
        },
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
        width: 40px;
        height: 40px;
        animation: spin 0.5s linear infinite;
        position: fixed;
        top: 70px;
        right: 30px;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
