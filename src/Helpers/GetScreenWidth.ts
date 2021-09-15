import { ref } from "vue";

const displayWidth = ref(window.innerWidth);
export function onResize() {
  displayWidth.value = window.innerWidth;
}
// window.addEventListener("resize", onResize);

export default displayWidth;
