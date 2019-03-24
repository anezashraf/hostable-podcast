import React from 'react'
import UploadFile from './UploadFile'
import { withRouter } from 'react-router-dom'
import PropTypes from "prop-types";
class CreateEpisodeForm extends React.Component {
  constructor (props) {
    super(props)

    this.state = {
      imageFile: '',
      audioFile: '',
      episode: {
      }
    }
  }

  componentDidUpdate (prevProps) {
    if (prevProps.isNewEpisodeSaving && this.props.isNewEpisodeSaving === false) {
      this.props.history.push('/dashboard/details')
    }
  }

  componentDidMount () {
    let { episode } = this.props

    this.setState({ episode: episode })
  }

    handleTitleChange = (e) => {
      this.setState({ title: e.target.value })
    };

    handleDescriptionChange = (e) => {
      this.setState({ description: e.target.value })
    };

    handleSave = (e) => {
      e.preventDefault()

      let { title, description, audioFile, imageFile } = this.state

      this.props.handleSave(title, description, audioFile, imageFile)
    }

    handleImageDrop = (imageFile) => {
      this.setState({ imageFile: imageFile })
    };

    handleAudioDrop = (audioFile) => {
      this.setState({ audioFile: audioFile })
    };

    render () {
      let { isNewEpisodeSaving } = this.props

      if (isNewEpisodeSaving) {
        return <p>Saving</p>
      }

      return (
        <div>
          <form onSubmit={this.handleSave}>
            <label>title</label>
            <input type="text" name="title" value={this.props.title} onChange={this.handleTitleChange}/>
            <input type="text" name="description" value={this.props.description} onChange={this.handleDescriptionChange}/>
            <button type="submit">Save</button>
          </form>
          <UploadFile
            isLoading={false}
            fileType="image"
            fileLocation={this.props.imageFileLocation}
            uploadFile={this.handleImageDrop}
          />

          <UploadFile
            isLoading={false}
            fileType="audio"
            fileLocation={this.props.audioFileLocation}
            uploadFile={this.handleAudioDrop}
          />
        </div>
      )
    }
}

CreateEpisodeForm.propTypes = {
  isNewEpisodeSaving: PropTypes.bool,
  history: PropTypes.object,
  episode: PropTypes.object,
  handleSave: PropTypes.func,
  title: PropTypes.string,
  description: PropTypes.string,
  imageFileLocation: PropTypes.string,
  audioFileLocation: PropTypes.string,
};

export default withRouter(CreateEpisodeForm)
