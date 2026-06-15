import axios from 'axios'

export default axios.create({
    baseURL: `${import.meta.env.VITE_API_URL}/api`,
    headers: {
        'Content-Type': 'application/json'
    }
})

const API_VERSION = import.meta.env.VITE_API_VERSION || 'v1'

const api = axios.create({
    baseURL: `${import.meta.env.VITE_API_URL}/api/${API_VERSION}`
})

export default api