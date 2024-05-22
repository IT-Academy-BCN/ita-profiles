import axios from "axios"

export const FetchStudentsProjects = async (studentUUID: string | null) => {
    try {
        const response = await axios.get(`https://itaperfils.eurecatacademy.org/api/v1/students/${studentUUID}/projects`);
        return response.data.projects;
    } catch (error) {
        throw new Error("Error fetching projects");
    }
};