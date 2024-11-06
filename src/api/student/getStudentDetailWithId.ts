import { getResourceWithAxios } from "../getResourceWithAxios"

type TResumes = {
    bootcamp: string,
    projects: string,
    collaborations: string,
    languages: string,
    additionaltraining: string,
    modality: string,
    detail: string,
    photo: string,
}
export const resumes: TResumes = {
    bootcamp: "bootcamp",
    projects: "projects",
    collaborations: "collaborations",
    languages: "languages",
    additionaltraining: "additionaltraining",
    modality: "modality",
    detail: "detail",
    photo: "photo",
}


const getStudentDetailWithId = async (studentId: string | null, ...args: string[]) => {

    const [resource] = args
    const keysResumes = Object.keys(resumes)
    const existResume: number = keysResumes.findIndex(resume => resume === resource)
    const resume: string = `resume/${resource}`;

    if (existResume !== -1) {
        const resourceStudent = await getResourceWithAxios(`/student/${studentId}/${resume}`)
        return resourceStudent
    }
    return null;
}

export {
    getStudentDetailWithId
}