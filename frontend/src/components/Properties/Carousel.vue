<template>
  <!-- Slideshow container -->
  <div class="slideshow-container" ref="slideShowContainer">
    <!-- Full-width images with number and caption text -->
    <div
      :id="`slide${i}`"
      class="slide fade"
      v-for="(image, i) in images"
      :key="i"
    >
      <div class="numbertext">{{ `${i + 1} / ${images.length}` }}</div>
      <img :src="image" style="width: 100%" />
    </div>

    <!-- Next and previous buttons -->
    <a class="prev" @click="plusSlides(-1)">&#10094;</a>
    <a class="next" @click="plusSlides(1)">&#10095;</a>
  </div>
  <br />

  <!-- The dots/circles -->
  <div style="text-align: center">
    <span
      class="dot"
      v-for="(image, i) in images"
      :key="i"
      @click="currentSlide(i)"
    ></span>
  </div>
</template>

<script lang="ts">
import {
  defineComponent,
  onMounted,
  PropType,
  ref,
  watch,
  watchEffect,
} from "vue";

export default defineComponent({
  props: {
    images: Object as PropType<Array<string>>,
  },
  setup() {
    const slideShowContainer = ref<HTMLDivElement>();
    let slideIndex = 1;
    const slides = ref<HTMLCollection>();
    const dots = ref<HTMLCollection>();
    function showSlides(n: number) {
      let i = 0;
      if (slides.value) {
        if (n > slides.value.length) {
          slideIndex = 1;
        }

        if (n < 1) {
          slideIndex = slides.value.length;
        }
        for (i = 0; i < slides.value.length; i++) {
          (slides.value[i] as HTMLDivElement).style.display = "none";
        }
      }
      if (dots.value) {
        for (i = 0; i < dots.value.length; i++) {
          dots.value[i].className = dots.value[i].className.replace(
            " active",
            ""
          );
        }
      }
      if (slides.value) {
        (slides.value[slideIndex - 1] as HTMLDivElement).style.setProperty(
          "display",
          "block"
        );
      }
      if (dots.value && dots.value[slideIndex - 1]) {
        dots.value[slideIndex - 1].classList.add(" active");
      }
    }
    watchEffect(() => {
      if (slideShowContainer.value !== undefined) {
        console.log("ss", slideShowContainer.value);
        slides.value =
          slideShowContainer.value?.getElementsByClassName("slide");
        console.log("slide", slides.value);
        dots.value = slideShowContainer.value?.getElementsByClassName("dot");
        console.log("dot", dots.value);
        showSlides(slideIndex);
      }
    });
    // onMounted(() => {
    //   slides.value = slideShowContainer.value?.getElementsByClassName("slides");
    //   dots.value = slideShowContainer.value?.getElementsByClassName("dot");
    //   showSlides(slideIndex);
    // });

    // Next/previous controls
    function plusSlides(n: any) {
      showSlides((slideIndex += n));
    }

    // Thumbnail image controls
    function currentSlide(n: any) {
      showSlides((slideIndex = n));
    }

    return {
      slideShowContainer,
      currentSlide,
      plusSlides,
    };
  },
});
</script>

<style scoped>
* {
  box-sizing: border-box;
}

/* Slideshow container */
.slideshow-container {
  max-width: 1000px;
  position: relative;
  margin: auto;
}

/* Hide the images by default */
.slide {
  display: none;
}

/* Next & previous buttons */
.prev,
.next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  margin-top: -22px;
  padding: 16px;
  color: white;
  font-weight: bold;
  font-size: 18px;
  transition: 0.6s ease;
  border-radius: 0 3px 3px 0;
  user-select: none;
}

/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover,
.next:hover {
  background-color: rgba(0, 0, 0, 0.8);
}

/* Caption text */
.text {
  color: #f2f2f2;
  font-size: 15px;
  padding: 8px 12px;
  position: absolute;
  bottom: 8px;
  width: 100%;
  text-align: center;
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

/* The dots/bullets/indicators */
.dot {
  cursor: pointer;
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

.active,
.dot:hover {
  background-color: #717171;
}

/* Fading animation */
.fade {
  -webkit-animation-name: fade;
  -webkit-animation-duration: 1.5s;
  animation-name: fade;
  animation-duration: 1.5s;
}

@-webkit-keyframes fade {
  from {
    opacity: 0.4;
  }
  to {
    opacity: 1;
  }
}

@keyframes fade {
  from {
    opacity: 0.4;
  }
  to {
    opacity: 1;
  }
}
</style>
