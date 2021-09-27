import ElementPlus from "element-plus";
import "../element-variables.scss";
import "element-plus/theme-chalk/src/index.scss";
import { App } from "vue";

export default (app: App): void => {
  app.use(ElementPlus);
};
