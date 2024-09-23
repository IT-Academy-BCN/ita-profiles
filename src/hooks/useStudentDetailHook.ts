import { useContext, useEffect } from "react";
import { TSmallScreenContext } from "../interfaces/interfaces";
import { useAppDispatch } from "./ReduxHooks";
import { SmallScreenContext } from "../context/SmallScreenContext";
import { useStudentIdContext } from "../context/StudentIdContext";
import getStudentDetail from "../store/reducers/getStudentDetail/studentDetailThunk";
import getStudentProjects from "../store/reducers/getStudentProjects/studentProjectsThunk";
import getStudentCollaborations from "../store/reducers/getStudentCollaborations/studentCollaborationsThunk";
import getStudentBootcamp from "../store/reducers/getStudentBootcamp/studentBootcampThunk";
import getStudentLanguages from "../store/reducers/getStudentLanguages/studentLanguagesThunk";

const useStudentDetailHook = (role?: string | null) => {
    const { isMobile }: TSmallScreenContext = useContext(SmallScreenContext)
    const { studentUUID } = useStudentIdContext()
    const studentID = localStorage.getItem("studentID")
    const getStudent = useAppDispatch();

    useEffect(() => {
        if (typeof role === "string" && role === "user") {
            getStudent(getStudentDetail(studentID))
            getStudent(getStudentProjects(studentID))
            getStudent(getStudentCollaborations(studentID))
            getStudent(getStudentBootcamp(studentID))
            getStudent(getStudentLanguages(studentID))
        } else if (!role && studentUUID) {
            getStudent(getStudentDetail(studentUUID))
            getStudent(getStudentProjects(studentUUID))
            getStudent(getStudentCollaborations(studentUUID))
            getStudent(getStudentBootcamp(studentUUID))
            getStudent(getStudentLanguages(studentUUID))
        }

    }, [getStudent, role, studentID, studentUUID])

    return { isMobile }
}

export {
    useStudentDetailHook,
}
