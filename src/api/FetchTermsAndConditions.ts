import axios from 'axios';

const BASE_URL = 'http://localhost:8000/api/v1';

export const fetchTermsAndConditions = async () => {
  try {
    const response = await axios.get(`${BASE_URL}/terms-and-conditions`);
    return response.data;
  } catch (error) {
    console.error('Error fetching terms and conditions:', error);
    throw error;
  }
};