import useJwt from '@core/auth/jwt/useJwt'
import axios from '@axios'

const { jwt } = useJwt(axios, {
	// Endpoints
	loginEndpoint: `${process.env.VUE_APP_API_BASEURL}/api/login`,
	registerEndpoint: `${process.env.VUE_APP_API_BASEURL}/api/register`,
	refreshEndpoint: '/jwt/refresh-token',
	logoutEndpoint: '/jwt/logout',

	// This will be prefixed in authorization header with token
	// e.g. Authorization: Bearer <token>
	tokenType: 'Bearer',

	// Value of this property will be used as key to store JWT token in storage
	storageTokenKeyName: 'accessToken',
	storageRefreshTokenKeyName: 'refreshToken',
})
export default jwt
