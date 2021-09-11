import { ref } from "vue";

const displayWidth = ref(window.innerWidth);
function onResize() {
  displayWidth.value = window.innerWidth;
}
window.addEventListener("resize", onResize);

export default displayWidth;
