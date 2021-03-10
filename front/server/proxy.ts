const devProxy: { [key: string]: {} } = {
    "/api": {
        target: "http://api",
        pathRewrite: { "^/api": "" },
        changeOrigin: true,
    },
};

export default devProxy;
