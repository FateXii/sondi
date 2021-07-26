import "./plugins/axios";
import { createApp } from "vue";
import App from "./App.vue";
import "./registerServiceWorker";
import router from "./router";
import store from "./store";
import installElementPlus from "./plugins/element";

const app = createApp(App).use(store).use(router);
installElementPlus(app);
app.mount("#app");
