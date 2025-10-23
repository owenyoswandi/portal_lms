function handleAuthorizationError(error) {
    if (error.response && error.response.status === 401) {
        alert('Authorization failed. Please check your access token.');
    } else {
        console.error('Error:', error);
    }
}

// axios.interceptors.request.use(
//     config => {
//         config.headers.Authorization = `Bearer ${accessToken}`;
//         return config;
//     },
//     error => {
//         return Promise.reject(error);
//     }
// );

axios.interceptors.response.use(
    response => {
        return response;
    },
    error => {
        handleAuthorizationError(error);
        return Promise.reject(error);
    }
);
