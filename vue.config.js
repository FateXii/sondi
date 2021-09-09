module.exports = {
  publicPath: process.env.NODE_ENV === "production" ? "/sondi-frontend/" : "/",
  chainWebpack: (config) => {
    config.watchOptions({
      aggregateTimeout: 300,
      poll: 1000,
    });
  },
};
