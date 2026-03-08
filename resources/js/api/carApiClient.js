// API Client Example - JavaScript/Axios
// Este archivo muestra cómo consumir la API REST desde una aplicación web

// Base URL de la API
const API_BASE_URL = '/api';

// Cliente API reutilizable
class CarApiClient {
    constructor() {
        this.token = localStorage.getItem('api_token');
    }

    // Obtener headers por defecto
    getHeaders(isFormData = false) {
        const headers = {};
        if (this.token) {
            headers['Authorization'] = `Bearer ${this.token}`;
        }
        if (!isFormData) {
            headers['Content-Type'] = 'application/json';
        }
        return headers;
    }

    // ============================================
    // CRUD 1: CARS (Público)
    // ============================================

    /**
     * Listar coches publicados
     * GET /api/cars
     */
    async getCars(filters = {}) {
        try {
            const params = new URLSearchParams(filters);
            const response = await fetch(`${API_BASE_URL}/cars?${params}`, {
                method: 'GET',
                headers: this.getHeaders()
            });
            return await response.json();
        } catch (error) {
            console.error('Error fetching cars:', error);
            throw error;
        }
    }

    /**
     * Obtener detalles de un coche
     * GET /api/cars/{id}
     */
    async getCar(carId) {
        try {
            const response = await fetch(`${API_BASE_URL}/cars/${carId}`, {
                method: 'GET',
                headers: this.getHeaders()
            });
            return await response.json();
        } catch (error) {
            console.error(`Error fetching car ${carId}:`, error);
            throw error;
        }
    }

    // ============================================
    // CRUD 2: CAR IMAGES (Autenticado)
    // ============================================

    /**
     * Login y obtener token
     * POST /api/login
     */
    async login(email, password) {
        try {
            const response = await fetch(`${API_BASE_URL}/login`, {
                method: 'POST',
                headers: this.getHeaders(),
                body: JSON.stringify({ email, password })
            });
            const data = await response.json();
            
            if (data.success) {
                this.token = data.data.token;
                localStorage.setItem('api_token', this.token);
            }
            return data;
        } catch (error) {
            console.error('Error login:', error);
            throw error;
        }
    }

    /**
     * Logout y revocar token
     * POST /api/logout
     */
    async logout() {
        try {
            const response = await fetch(`${API_BASE_URL}/logout`, {
                method: 'POST',
                headers: this.getHeaders()
            });
            const data = await response.json();
            
            if (data.success) {
                this.token = null;
                localStorage.removeItem('api_token');
            }
            return data;
        } catch (error) {
            console.error('Error logout:', error);
            throw error;
        }
    }

    /**
     * Listar imágenes del usuario autenticado
     * GET /api/car-images
     */
    async getCarImages(carId = null) {
        try {
            const url = carId 
                ? `${API_BASE_URL}/cars/${carId}/images`
                : `${API_BASE_URL}/car-images`;
                
            const response = await fetch(url, {
                method: 'GET',
                headers: this.getHeaders()
            });
            return await response.json();
        } catch (error) {
            console.error('Error fetching images:', error);
            throw error;
        }
    }

    /**
     * Subir una imagen para un coche
     * POST /api/cars/{carId}/images
     */
    async uploadCarImage(carId, imageFile, position = null) {
        try {
            const formData = new FormData();
            formData.append('image', imageFile);
            if (position) {
                formData.append('position', position);
            }

            const response = await fetch(`${API_BASE_URL}/cars/${carId}/images`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${this.token}`
                },
                body: formData
            });
            return await response.json();
        } catch (error) {
            console.error('Error uploading image:', error);
            throw error;
        }
    }

    /**
     * Actualizar posición de imagen
     * PUT /api/car-images/{imageId}
     */
    async updateCarImage(imageId, data) {
        try {
            const response = await fetch(`${API_BASE_URL}/car-images/${imageId}`, {
                method: 'PUT',
                headers: this.getHeaders(),
                body: JSON.stringify(data)
            });
            return await response.json();
        } catch (error) {
            console.error(`Error updating image ${imageId}:`, error);
            throw error;
        }
    }

    /**
     * Eliminar una imagen
     * DELETE /api/car-images/{imageId}
     */
    async deleteCarImage(imageId) {
        try {
            const response = await fetch(`${API_BASE_URL}/car-images/${imageId}`, {
                method: 'DELETE',
                headers: this.getHeaders()
            });
            return await response.json();
        } catch (error) {
            console.error(`Error deleting image ${imageId}:`, error);
            throw error;
        }
    }
}

// Instancia global
const carApi = new CarApiClient();

// ============================================
// EJEMPLOS DE USO
// ============================================

/**
 * Ejemplo 1: Obtener lista de coches (público)
 */
async function exampleGetCars() {
    try {
        const result = await carApi.getCars({
            per_page: 10,
            price_min: 5000,
            price_max: 50000
        });
        console.log('Cars:', result.data);
    } catch (error) {
        console.error('Error:', error);
    }
}

/**
 * Ejemplo 2: Obtener detalles de un coche (público)
 */
async function exampleGetCar(carId) {
    try {
        const result = await carApi.getCar(carId);
        console.log('Car details:', result.data);
    } catch (error) {
        console.error('Error:', error);
    }
}

/**
 * Ejemplo 3: Login y obtener token
 */
async function exampleLogin() {
    try {
        const result = await carApi.login(
            'user@example.com',
            'password123'
        );
        console.log('Login successful, token:', carApi.token);
    } catch (error) {
        console.error('Error:', error);
    }
}

/**
 * Ejemplo 4: Subir imagen (requiere autenticación)
 */
async function exampleUploadImage(carId, imageFile) {
    try {
        const result = await carApi.uploadCarImage(carId, imageFile);
        console.log('Image uploaded:', result.data);
    } catch (error) {
        console.error('Error:', error);
    }
}

/**
 * Ejemplo 5: Obtener imágenes de un coche
 */
async function exampleGetCarImages(carId) {
    try {
        const result = await carApi.getCarImages(carId);
        console.log('Car images:', result.data);
    } catch (error) {
        console.error('Error:', error);
    }
}

/**
 * Ejemplo 6: Eliminar una imagen
 */
async function exampleDeleteImage(imageId) {
    try {
        const result = await carApi.deleteCarImage(imageId);
        console.log('Image deleted:', result.message);
    } catch (error) {
        console.error('Error:', error);
    }
}

/**
 * Ejemplo 7: Logout
 */
async function exampleLogout() {
    try {
        const result = await carApi.logout();
        console.log('Logout successful');
    } catch (error) {
        console.error('Error:', error);
    }
}

// Export para uso en otros módulos
export default carApi;
