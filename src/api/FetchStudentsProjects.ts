import axios from "axios"

export const fetchStudentsProjects = async (studentId: string | null) => {
    try {
        const response = await axios.get(`//localhost:8000/api/v1/student/${studentId}/resume/projects`);
        return response.data.projects;
    } catch (error) {
        throw new Error("Error fetching projects");
    }
};
