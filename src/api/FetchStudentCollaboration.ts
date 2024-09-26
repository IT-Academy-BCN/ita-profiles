import axios from "axios"

export const fetchStudentsCollaboration = async (studentId: string | null) => {
    try {
        const response = await axios.get(`//localhost:8000/api/v1/student/${studentId}/resume/collaborations`);
        return response.data.collaborations;
    } catch (error) {
        throw new Error('Error fetching collaboration');
    }
};
