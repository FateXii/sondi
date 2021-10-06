<template>
  <iframe
    class="video"
    :src="`https://www.youtube.com/embed/${video_id}?controls=1`"
    title="YouTube video player"
    frameborder="0"
    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
    allowfullscreen
  ></iframe>
</template>
<script lang="ts">
import { defineComponent, toRefs } from "vue";

function youtube_parser(url: string) {
  const regExp =
    /^.*(?:(?:youtu\.be\/|v\/|vi\/|u\/\w\/|embed\/)|(?:(?:watch)?\?v(?:i)?=|&v(?:i)?=))([^#&?]*).*/;
  const match = url.match(regExp);
  return match && match[1];
}
export default defineComponent({
  props: {
    src: {
      type: String,
      required: true,
    },
  },
  setup(props) {
    const { src: video_url } = toRefs(props);
    const video_id = youtube_parser(video_url.value);
    return {
      video_id,
    };
  },
});
</script>
<style lang="scss" scoped>
.video {
  width: 100%;
  @media (min-width: 425px) {
    height: 20rem;
  }
  @media (min-width: 767px) {
    height: 40rem;
  }
  @media (min-width: 1023px) {
    height: 50rem;
  }
}
</style>
