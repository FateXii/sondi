import { ref } from "vue";
const screenWidth = ref(window.innerWidth);
const changeScreenWidth = (e: any) => {
  screenWidth.value = e.view?.innerWidth || window.innerWidth;
};
window.addEventListener("resize", changeScreenWidth);
export default screenWidth;
