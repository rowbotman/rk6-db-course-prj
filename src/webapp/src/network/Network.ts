type TMethod = 'GET' | 'POST' | 'PUT' | 'DELETE' | 'PATCH';

export class Network {
	static fetchGet = async <T = {}, R = {}>(path = '/', api = HOST) => {
		console.log(path);
		return Network.fetchRequest<T, R>('GET', path, api);
	};

	static fetchRequest = async <T = {}, R = {}>(method: TMethod, path: string, api = HOST, body: T = null): Promise<R> => {
		if (path.includes('undefined')) {
			throw new Error('Invalid path, boy');
		}
		const res = await fetch(`${api}/${path}`, {
			method,
			mode: 'cors',
			credentials: 'include',
			headers: body ? {
				'Content-Type': 'application/json; charset=utf-8',
			} : {},
			body: body ? JSON.stringify(body) : null,
		});
		return await res.json();
	};

	static fetchDelete = async <T = {}, R = {}>(path: string, body: T = null, api = HOST) => {
		return Network.fetchRequest('DELETE', path, api, body);
	};

	static fetchPost = async <T = {}, R = {}>(path: string, body: T = null, api = HOST) => {
		return Network.fetchRequest<T, R>('POST', path, api, body);
	};

	static fetchPut = async <T = {}, R = {}>(path: string, body: T = null, api = HOST) => {
		return Network.fetchRequest<T, R>('PUT', path, api, body);
	};
}
