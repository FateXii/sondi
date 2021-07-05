module.exports = {
  publicPath: process.env.NODE_ENV === "production" ? "/sondi-frontend/" : "/",
  css: {
    loaderOptions: {
      sass: {
        additionalData: '@import "@/scss/main.scss";',
      },
    },
  },
};
