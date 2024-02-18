import { defineStore } from 'pinia'
import axios from 'axios';
import Cookies from 'js-cookie';

const apiClient = axios.create({
    baseURL: '/api',
    withCredentials: true,
});


apiClient.interceptors.request.use((config) => {
    const token = Cookies.get('token');

    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
        config.headers.Accept = 'application/json';
    }
    return config;
});

export const useProductStore = defineStore('products', {
    state: () => ({
        products: null,
        product: null,
        totalPages: 0,
        currentPage: 0,
        categories: null,
        currentRequest: 'fetchAll',
        lastSearch: '',
        lastCategory: '',
        pageForFetchAll: 1,
        pageForSingleCategory: 1,
        pageForSearchProduct: 1,
        ismethodChanged: false,
        message: {
            error: '',
            success: ''
        }
    }),
    actions: {
        // FETCH ALL PRODUCT EXCEPT PHOTOS
        async loadProduct() {
            try {
                const response = await axios.get('/api/fetchAllProduct', { params: { page: this.pageForFetchAll } })
                this.products = response.data.products.data
                this.currentPage = response.data.products.current_page
                this.totalPages = response.data.products.last_page
                this.currentRequest = 'fetchAll'
            } catch (error) {
                this.message.error = error
            }
        },

        // FETCH ALL CATEGORIES
        async getAllCategory() {
            try {
                const response = await axios.get('/api/fetchAllCategories')
                this.categories = response.data.category
            } catch (error) {
                this.message.error = error
            }
        },

        // FETCH SINGLE CATEGORY
        async getSingleCategory(category) {
            try {
                this.lastCategory = category //store the last search value for pagination used
                const response = await axios.post(`/api/getSingleCategory/`, { category: this.lastCategory }, {
                    params: {
                        page: this.pageForSingleCategory,
                    },
                })

                this.products = response.data.products.data
                this.currentPage = response.data.products.current_page
                this.totalPages = response.data.products.last_page
                this.currentRequest = 'singleCategory'
            } catch (error) {
                this.message.error = error
            }
        },

        // SEARCH PRODUCT
        async searchProduct(search) {

            try {
                this.lastSearch = search //store the last search value for pagination used
                const response = await axios.get(`/api/searchProduct/${this.lastSearch}`, { params: { page: this.pageForSearchProduct } })
                this.products = response.data.product.data
                this.currentPage = response.data.product.current_page
                this.totalPages = response.data.product.last_page
                this.currentRequest = 'searchProduct'
            } catch (error) {
                this.message.error = error
            }
        },

        // CREATE PRODUCT
        async CreateProduct(form) {
            try {
                const response = await axios.post('/products/create', form, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                })
                this.message.success = response.data.message
                await this.loadProduct();
            } catch (error) {
                this.message.error = error
            }
        },

        // UPDATE PRODUCT
        async UpdateProduct(form, id) {

            try {
                const response = await axios.post(`/products/update/${id}`, form, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                })

                this.message.success = response.data.message
                await this.loadProduct();
            } catch (error) {
                this.message.error = error
                console.log(error)
            }
        },

        // FETCH ALL PRODUCT WITH PHOTOS
        async getAllProductWPhoto(id) {
            try {
                const response = await axios.get(`/api/fetchAllproductWithPhoto/${id}`)
                this.product = response.data.product
            } catch (error) {
                this.message.error = error
            }
        },

        // DELETE A SINGLE PRODUCT
        async RemoveProduct(id) {
            try {
                const response = await axios.delete(`/api/deleteProduct/${id}`)
                this.message.success = response.data.message
                await this.loadProduct();
            } catch (error) {
                this.message.error = error
            }
        },

        // PAGINATION METHOS FOR SWITCHING PAGES
        async goToPage(page) {
            if (page >= 1 && page <= this.totalPages) {
                if (this.ismethodChanged) {
                    // Reset the current page when the method has changed
                    this.currentPage = 1;
                    this.methodChanged = false;
                }

                switch (this.currentRequest) {
                    case 'fetchAll':
                        this.pageForFetchAll = page;
                        await this.loadProduct();
                        break;
                    case 'singleCategory':
                        this.pageForSingleCategory = page;
                        await this.getSingleCategory(this.lastCategory);
                        break;
                    case 'searchProduct':
                        this.pageForSearchProduct = page;
                        await this.searchProduct(this.lastSearch);
                        break;
                    default:
                        this.pageForFetchAll = page;
                        await this.loadProduct();
                }
            }
        }
    }
})