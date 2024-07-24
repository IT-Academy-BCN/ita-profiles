import { Navigate, Outlet } from 'react-router-dom'

const ProtectedRoute = ({
    canActivate,
    redirectPath = "/",
}: { canActivate: boolean; redirectPath?: string }): JSX.Element => {
    if (!canActivate) {
      return <Navigate to={redirectPath} replace />
    }
    return <Outlet />;
}

export default ProtectedRoute