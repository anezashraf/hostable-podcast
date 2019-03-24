import React from 'react'
import { bindActionCreators } from 'redux'
import { fetchEpisodes, updateEpisode, uploadImage, uploadAudio } from '../Reducers/episode'
import { Link } from 'react-router-dom'

import { connect } from 'react-redux'
import EpisodeForm from '../Components/Forms/EpisodeForm'
import PropTypes from "prop-types";

class Episodes extends React.Component {
  componentDidMount () {
    this.props.fetchEpisodes()
  }

  render () {
    let { episodes, updateEpisode, uploadImage, uploadAudio, isAudioUploading, isImageUploading } = this.props

    return (
      <section>
        <Link to={'/dashboard/create-episode'}>Create New Episode</Link>
        {episodes.map((value, index) => {
          let imageFileLocation = value.image;
          let audioFileLocation = value.enclosureUrl;
          return (
            <EpisodeForm
              uploadAudio={uploadAudio}
              uploadImage={uploadImage}
              key={index}
              title={value.title}
              description={value.description}
              imageFileLocation={imageFileLocation}
              audioFileLocation={audioFileLocation}
              handleSave={updateEpisode}
              isImageUploading={isImageUploading}
              isAudioUploading={isAudioUploading}
            />
          )
        })}
      </section>
    )
  }
}


Episodes.propTypes = {
    fetchEpisodes: PropTypes.func,
    episodes: PropTypes.array``,
    updateEpisode: PropTypes.func,
    uploadImage: PropTypes.func,
    uploadAudio: PropTypes.func``,
    isAudioUploading: PropTypes.bool,
    isImageUploading: PropTypes.bool,
};


const mapStateToProps = ({ episode }) => ({
  episodes: episode.episodes,
  isAudioUploading: episode.isAudioUploading,
  isImageUploading: episode.isImageUploading
})

const mapDispatchToProps = dispatch =>
  bindActionCreators(
    {
      fetchEpisodes,
      updateEpisode,
      uploadImage,
      uploadAudio
    },
    dispatch
  );

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(Episodes)
