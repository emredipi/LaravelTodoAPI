import Home from './components/Home';
import TodoList from "./components/TodoList";
import News from "./components/News";
export default {
    mode: "history",
    routes:[
        {
            path:'/home',
            alias:'/',
            component:Home,
            text:"Home"
        },
        {
            path:'/list',
            component:TodoList,
            text:"list"
        },
        {
            path:'/news',
            component:News,
            text:"News"
        }
    ]
}
