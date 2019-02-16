import React from 'react'
import classNames from 'classnames'
import Dropzone from 'react-dropzone'

class PodcastForm extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            title: '',
            description: '',
            accepted: [],
            rejected: []
        }
    }

    componentDidMount() {
        let {title, description, id} = this.props;

        this.setState({
            title: title,
            description: description,
            id: id
        });
    }

    handleTitleChange = (e) => {
        this.setState({title: e.target.value});
    };

    handleDescriptionChange = (e) => {
        this.setState({description: e.target.value});
    };

    handleDrop = (file) => {
        this.props.uploadImage(file[0], this.state.id);
    };

    handleSave = (e) => {
        e.preventDefault();
        this.props.handleSave(this.state.title, this.state.description, this.props.id)
    }

    render() {

        let {title, description} = this.state;

        return (
            <div>
                <form onSubmit={this.handleSave}>
                    <input type="text" name="title" value={title} onChange={this.handleTitleChange}/>
                    <input type="text" name="description" value={description} onChange={this.handleDescriptionChange}/>
                    <button type="submit">Save</button>
                </form>
                <div className="dropzone">
                    <Dropzone
                        accept="image/jpeg, image/png"
                        onDrop={this.handleDrop}
                    >
                        {({ getRootProps, getInputProps }) => (
                            <div {...getRootProps()}  className="dropzone">
                                <input {...getInputProps()} />
                                <p>Upload The Podcast Image</p>
                            </div>
                        )}
                    </Dropzone>
                </div>
                <aside>
                    <h4>Accepted files</h4>
                    <ul>
                        {
                            this.state.accepted.map(f => <li key={f.name}>{f.name} - {f.size} bytes</li>)
                        }
                    </ul>
                </aside>
            </div>
        )
    }
}

export default PodcastForm