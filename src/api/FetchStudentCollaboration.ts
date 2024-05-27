import axios from "axios"

export const FetchStudentsCollaboration = async (studentUUID: string | null) => {
    try {
        const response = await axios.get(`/api/v1/students/${studentUUID}/collaborations`);
        return response.data.collaborations;
    } catch (error) {
        throw new Error('Error fetching collaboration');
    }
};
