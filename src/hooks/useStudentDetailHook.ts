import { useContext, useEffect } from "react";
import getStudenDetail from "../store/reducers/getStudenDetail/thunks/studenDetailThunk";
import { TSmallScreenContext } from "../interfaces/interfaces";
import { useAppDispatch } from "./ReduxHooks";
import { SmallScreenContext } from "../context/SmallScreenContext";
import { useStudentIdContext } from "../context/StudentIdContext";
import getStudenProjects from "../store/reducers/getStudenProjects/studenProjectsThunk";
import getStudentCollaborations from "../store/reducers/getStudentCollaborations/studentCollaborationsThunk";
import getStudenBootcamp from "../store/reducers/getStudentBootcamp/getStudenBootcampThunk";

const useStudentDetailHook = (rol?: string | null) => {
    const { isMobile }: TSmallScreenContext = useContext(SmallScreenContext)
    const { studentUUID } = useStudentIdContext()
    const studentSUID = localStorage.getItem("studentSUID")
    const getStudent = useAppDispatch();

    useEffect(() => {
        if (typeof rol === "string" && rol === "user") {
            getStudent(getStudenDetail(studentSUID))
            getStudent(getStudenProjects(studentSUID))
            getStudent(getStudentCollaborations(studentSUID))
            getStudent(getStudenBootcamp(studentSUID))
        } else if (!rol && studentUUID) {
            getStudent(getStudenDetail(studentUUID))
            getStudent(getStudenProjects(studentUUID))
            getStudent(getStudentCollaborations(studentUUID))
            getStudent(getStudenBootcamp(studentUUID))
        }

    }, [getStudent, rol, studentSUID, studentUUID])

    return { isMobile }
}

export {
    useStudentDetailHook,
}