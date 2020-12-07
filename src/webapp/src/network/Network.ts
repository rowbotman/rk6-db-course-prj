type TMethod = 'GET' | 'POST' | 'PUT' | 'DELETE' | 'PATCH';

export class Network {
	static fetchGet = async <T = {}>(path = '/', api = HOST) => {
		return Network.fetchRequest('GET', path, api);
	};

	static fetchRequest = async <T = {}>(method: TMethod, path: string, api = HOST, body: T = null) => {
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

	static fetchDelete = async <T = {}>(path: string, body: T = null, api = HOST) => {
		return Network.fetchRequest('DELETE', path, api, body);
	};

	static fetchPost = async <T = {}>(path: string, body: T = null, api = HOST) => {
		return Network.fetchRequest('POST', path, api, body);
	};
}
