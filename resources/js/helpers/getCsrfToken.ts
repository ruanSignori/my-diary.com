import axios from 'axios';

/**
 * Obtém o valor do Token CSRF
 * através da API do sanctum
 */
const getCsrfToken = async () => {
  const token = await axios.get('/sanctum/csrf-cookie');
  return token;
}

export { getCsrfToken };
